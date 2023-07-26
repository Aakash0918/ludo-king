<?php

namespace App\Libraries;

use App\Models\ApplicationModel;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Room implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later

        try {
            //code...
            $uriQuery = $conn->httpRequest->getUri()->getQuery(); // access_token=
            $uriQuery = explode("=", $uriQuery);
            echo sprintf(
                'Connection sending message "%s"' . "\n",
                $conn->resourceId,
            );
            $ciphertext = hex2bin(urldecode($uriQuery[1]));
            $encrypter = \Config\Services::encrypter();
            $data = json_decode($encrypter->decrypt($ciphertext), true);

            $userModel = new ApplicationModel('users', 'uid');
            $user = $userModel->find($data['user_id'] ?? '');
            if (!$user) {
                $conn->send(json_encode(['status' => false, 'code' => 401, 'message' => "User not available"]));
                // $conn->close();
            } else {
                $connectionModel = new ApplicationModel('connections', 'c_id');
                $check = $connectionModel->select(['c_id', 'c_user_id'])->where(['pool_id' => $data['pool_id'], 'amount' => $data['amount'], 'winning_amount' => $data['winning_amount']])->first();
                if ($check) {
                    if ($check['c_user_id'] == $user['uid']) {
                        $connectionModel->where(['c_id' => $check['c_id']])->delete();
                        $conUser = [
                            'c_user_id' => $user['uid'],
                            'c_resource_id' => $conn->resourceId,
                            'c_name' => $user['user_name'] ?? '',
                            'pool_id' => $data['pool_id'],
                            'amount' => $data['amount'],
                            'winning_amount' => $data['winning_amount']
                        ];
                        $connectionModel->insert($conUser);
                        $conn->user = $conUser;
                        $this->clients->attach($conn);
                        $conn->send(json_encode(['status' => true, 'message' => 'Waiting for second player', 'code' => 200, 'match' => false]));
                        echo "New connection! ({$conn->resourceId})\n";
                    } else {
                        // generate game id here
                        $payment = deducatePoolPrice([$user['uid'], $check['c_user_id']], $data['amount']);
                        if ($payment['status']) {
                            $roomId = $this->generateRoomId();
                            if ($roomId['status']) {
                                // join match
                                $lobbyModel = new ApplicationModel('lobbies', 'lid');
                                $lobbyData = [
                                    'game_id' => $data['pool_id'],
                                    'room_id' => sprintf("%'.08d", $roomId['room_id']),
                                    'per_head_amt' => $data['amount'],
                                    'wining_amt' => $data['winning_amount'],
                                    'service_amt' => ((2 * $data['amount']) - $data['winning_amount']),
                                    'lobby_status' => 0
                                ];
                                $lobby = $lobbyModel->insert($lobbyData);
                                if ($lobby) {
                                    $lobbyUserData = [
                                        ['lobby_id' => $lobby, 'user_id' => $user['uid']],
                                        ['lobby_id' => $lobby, 'user_id' => $check['c_user_id']]
                                    ];
                                    $lobbyPlayerModel = new ApplicationModel('players', 'pid');
                                    $x = $lobbyPlayerModel->insertBatch($lobbyUserData);
                                    if ($x) {
                                        $message = ['status' => true, 'message' => 'find Match', 'data' => $lobbyData, 'code' => 200, 'match' => true];
                                        foreach ($this->clients as $client) {
                                            if ($client->user['c_user_id'] == $check['c_user_id']) {
                                                $client->send(json_encode($message));
                                                $this->clients->detach($client);
                                                $connectionModel->where(['c_id' => $check['c_id']])->delete();
                                                break;
                                            }
                                        }
                                        $conn->send(json_encode($message));
                                    } else {
                                        $lobbyModel->delete($lobby);
                                        $message = ['status' => false, 'message' => 'Something went wrong try again. Your amount has been refunded.', 'code' => 200, 'reload' => true];
                                        $this->refund([$user['uid'], $check['c_user_id']], $data['amount']);
                                        foreach ($this->clients as $client) {
                                            if ($client->user['c_user_id'] == $check['c_user_id']) {
                                                $client->send(json_encode($message));
                                                $this->clients->detach($client);
                                                $connectionModel->where(['c_id' => $check['c_id']])->delete();
                                                break;
                                            }
                                        }
                                        $conn->send(json_encode($message));
                                    }
                                } else {
                                    $message = ['status' => false, 'message' => 'Something went wrong try again. Your amount has been refunded.', 'code' => 200, 'reload' => true];
                                    foreach ($this->clients as $client) {
                                        if ($client->user['c_user_id'] == $check['c_user_id']) {
                                            $client->send(json_encode($message));
                                            $this->clients->detach($client);
                                            $connectionModel->where(['c_id' => $check['c_id']])->delete();
                                            break;
                                        }
                                    }
                                    $conn->send(json_encode($message));
                                }
                            } else {
                                // refund pool amount here
                                $message = ['status' => false, 'message' => 'Something went wrong try again. Your amount has been refunded.', 'code' => 200, 'reload' => true];
                                $this->refund([$user['uid'], $check['c_user_id']], $data['amount']);
                                foreach ($this->clients as $client) {
                                    if ($client->user['c_user_id'] == $check['c_user_id']) {
                                        $client->send(json_encode($message));
                                        $this->clients->detach($client);
                                        $connectionModel->where(['c_id' => $check['c_id']])->delete();
                                        break;
                                    }
                                }
                                $conn->send(json_encode($message));
                            }
                        } else {
                            if (($payment['data'] ?? '')) {
                                $message = ['status' => false, 'message' => $payment['messages'], 'code' => 200, 'reload' => true];
                                foreach ($this->clients as $client) {
                                    if ($client->user['c_user_id'] == $check['c_user_id']) {
                                        $client->send(json_encode($message));
                                        $this->clients->detach($client);
                                        $connectionModel->where(['c_id' => $check['c_id']])->delete();
                                        break;
                                    }
                                }

                                $conn->send(json_encode($message));
                            } else {
                                $conn->send(json_encode(['status' => false, 'code' => 200, 'message' => "Something went wrong. kindly talk to support.", 'reload' => true]));
                            }
                        }
                    }
                } else {
                    $conUser = [
                        'c_user_id' => $user['uid'],
                        'c_resource_id' => $conn->resourceId,
                        'c_name' => $user['user_name'] ?? '',
                        'pool_id' => $data['pool_id'],
                        'amount' => $data['amount'],
                        'winning_amount' => $data['winning_amount']
                    ];
                    $connectionModel->insert($conUser);
                    $conn->user = $conUser;
                    $this->clients->attach($conn);
                    $conn->send(json_encode(['status' => true, 'message' => 'Waiting for second player', 'code' => 200, 'match' => false]));
                    echo "New connection! ({$conn->resourceId})\n";
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            //echo "An error has occurred: {$th->getMessage()}\n";
            //dd($th);
            $conn->send(json_encode(['status' => false, 'code' => 404, 'message' => "Something went wrong. kindly talk to support.", 'mess' => $th->getMessage()]));
            //$conn->close();
        }
        // ws://localhost:8080/?access_token=12344

    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients) - 1;
        echo sprintf(
            'Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId,
            $msg,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        try {
            //code...
            $uriQuery = $conn->httpRequest->getUri()->getQuery(); // access_token=
            $uriQuery = explode("=", $uriQuery);
            echo sprintf(
                'Connection sending message "%s"' . "\n",
                $conn->resourceId
            );
            $ciphertext = hex2bin(urldecode($uriQuery[1]));
            $encrypter = \Config\Services::encrypter();
            $data = json_decode($encrypter->decrypt($ciphertext), true);

            $userModel = new ApplicationModel('users', 'uid');
            $user = $userModel->find($data['user_id'] ?? '');
            if ($user) {
                $connectionModel = new ApplicationModel('connections', 'c_id');
                $connectionModel->where(['pool_id' => $data['pool_id'], 'amount' => $data['amount'], 'winning_amount' => $data['winning_amount'], 'c_user_id' => $data['user_id']])->delete();
            }
            $this->clients->detach($conn);
        } catch (\Throwable $th) {

            //$conn->close();
            $this->clients->detach($conn);
        }
        // The connection is closed, remove it, as we can no longer send it messages


        //$connectionModel = new ApplicationModel('connections', 'c_id');
        echo $conn->resourceId;
        //$conn->close();
        //$connectionModel->where(['c_resource_id' => 1])->delete();
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    protected function generateRoomId()
    {
        $client = \Config\Services::curlrequest();
        $response = $client->request('GET', 'https://api.ludoadda.co.in/api.php?uname=YWRtaW4xMjM=&key=VjFSS05HRkhUWHBVYmtKYVpIb3dPUT09');
        $resp = json_decode($response->getBody() ?? '[]', true);
        if ($resp['roomcode'] ?? '') {
            return ['status' => true, 'room_id' => sprintf("%'.08d", $resp['roomcode'])];
        }
        return ['status' => false, 'message' => "API Does not work"];
    }

    protected function refund($userIds, $amount)
    {

        $userModel = new ApplicationModel('users', 'uid');
        $modelData = [];
        foreach ($userIds as $key => $user) {
            $user = $userModel->where(['uid' => $user])->first();
            $modelData[] = [
                'user_id' => $user,
                'amount' => $amount,
                'amount_type' => 'cr',
                'transaction_type' => 'refund',
                'before_balance' => $user['balance'],
                'after_balance' => $user['balance'] + $amount,
                'is_withdrawable' => true,
            ];
        }
        $model = new ApplicationModel('wallet_transactions', 'wid');
        $x = $model->insertBatch($modelData);
        if ($x) {
            $y = $userModel->set('balance', '`balance` + ' . $amount, false)->whereIn('uid', $userIds)->update();
            return  $y ? true : false;
        }
        return false;
    }
}
