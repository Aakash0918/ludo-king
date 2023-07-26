<?php

namespace App\Controllers;

use App\Models\ApplicationModel;
use CodeIgniter\Database\BaseBuilder;

class Admin extends BaseController
{

    /******************* Login Start *******************/

    public function index()
    {
        return $this->battles();
    }

    /******************* Login End *******************/

    public function battles()
    {
        $model = new ApplicationModel('game_pools', 'gp_id');

        $data['battles'] = $model->select(['gp_id', 'pool_price', 'winning_price', 'capacity', 'gp_type', 'gp_status', 'gp_created_at', 'live_users'])->where(['gp_delete_status' => 0, 'gp_type' => 1])->orderBy('gp_id', 'DESC')->paginate(500);
        $data['pager'] = $model->pager;

        return view('admin/common/header') . view('admin/common/menubar') . view('admin/battles', $data) . view('admin/common/footer');
    }
    public function add_battle()
    {
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'pool_price' => 'required|numeric',
                'winning_price' => 'required|numeric',
                'capacity' => 'required|in_list[2]',
                'status' => 'required|in_list[0,1]',
            ];
            $errors = [
                'pool_price' => [
                    'required' => 'Pool Price is required.',
                    'numeric' => 'Pool Price has been support digits only.',
                ],
                'winning_price' => [
                    'required' => 'Winning Price is required.',
                    'numeric' => 'Winning Price has been support digits only.',
                ],
                'capacity' => [
                    'requierd' => 'Capacity is required.',
                    'in_list' => 'Capacity is not valid.'
                ],
                'status' => [
                    'requierd' => 'Status is required.',
                    'in_list' => 'Status is not valid.'
                ]
            ];
            if (!$this->validate($rules, $errors)) {
                session()->setFlashdata('toastr', ['error' => 'Validation Error Occurs.']);
                return redirect()->withInput()->back();
            } else {
                $postData = $this->request->getPost();
                $model = new ApplicationModel('game_pools', 'gp_id');
                $check = $model->select('gp_id')->where(['pool_price' => $postData['pool_price'], 'winning_price' => $postData['winning_price'], 'capacity' => $postData['capacity']])->first();
                if ($check) {
                    session()->setFlashdata('toastr', ['error' => 'Battle already exits.']);
                    return redirect()->withInput()->back();
                }
                $battleData = [
                    'unique_id' => uniqid('GP'),
                    'pool_price' => $postData['pool_price'],
                    'winning_price' => $postData['winning_price'],
                    'capacity' => $postData['capacity'],
                    'gp_status' => $postData['status']
                ];
                $x = $model->insert($battleData);
                if ($x) {
                    session()->setFlashdata('toastr', ['success' => 'Battle successfully added.']);
                    return redirect()->to('/admin/battles');
                } else {
                    session()->setFlashdata('toastr', ['error' => 'Internal server Error']);
                    return redirect()->withInput()->back();
                }
            }
        }

        return view('admin/common/header') . view('admin/common/menubar') . view('admin/addbattle') . view('admin/common/footer');
    }

    public function edit_battle($id = "")
    {
        $model =  new ApplicationModel('game_pools', 'gp_id');

        $detail = $model->where(['gp_id' => $id])->first() ?? [];
        if (!$detail) {
            session()->setFlashdata('toastr', ['error' => 'Battle not exit.']);
            return redirect()->back();
        }
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'pool_price' => 'required|numeric',
                'winning_price' => 'required|numeric',
                'capacity' => 'required|in_list[2]',
                'status' => 'required|in_list[0,1]',
            ];
            $errors = [
                'pool_price' => [
                    'required' => 'Pool Price is required.',
                    'numeric' => 'Pool Price has been support digits only.',
                ],
                'winning_price' => [
                    'required' => 'Winning Price is required.',
                    'numeric' => 'Winning Price has been support digits only.',
                ],
                'capacity' => [
                    'requierd' => 'Capacity is required.',
                    'in_list' => 'Capacity is not valid.'
                ],
                'status' => [
                    'requierd' => 'Status is required.',
                    'in_list' => 'Status is not valid.'
                ]
            ];
            if (!$this->validate($rules, $errors)) {
                session()->setFlashdata('toastr', ['error' => 'Validation Error Occurs.']);
                return redirect()->withInput()->back();
            } else {
                $postData = $this->request->getPost();
                $model = new ApplicationModel('game_pools', 'gp_id');
                $check = $model->select('gp_id')->where(['pool_price' => $postData['pool_price'], 'winning_price' => $postData['winning_price'], 'capacity' => $postData['capacity'], 'gp_id!=' => $id])->first();
                if ($check) {
                    session()->setFlashdata('toastr', ['error' => 'Battle already exits.']);
                    return redirect()->withInput()->back();
                }
                $battleData = [
                    'gp_id' => $id,
                    'pool_price' => $postData['pool_price'],
                    'winning_price' => $postData['winning_price'],
                    'capacity' => $postData['capacity'],
                    'gp_status' => $postData['status']
                ];
                $x = $model->save($battleData);
                if ($x) {
                    session()->setFlashdata('toastr', ['success' => 'Battle successfully updated.']);
                    return redirect()->to('/admin/battles');
                } else {
                    session()->setFlashdata('toastr', ['error' => 'Internal server Error']);
                    return redirect()->withInput()->back();
                }
            }
        }
        $data['detail'] = $detail;
        return view('admin/common/header') . view('admin/common/menubar') . view('admin/edit-battle', $data) . view('admin/common/footer');
    }

    public function users()
    {
        $model =  new ApplicationModel('users', 'uid');
        $data['keyStats'] = $model->select(['user_status', '(CASE WHEN user_status=1 THEN "Active" ELSE "Dective" END) status_name', 'COUNT(user_status) total'])->where('user_detele_status', 0)->groupBy('user_status')->orderBy('user_status', 'DESC')->findALL() ?? [];

        $model->select(['user_name', 'mobile', 'email', 'referal_code', 'balance', 'user_status', 'user_created_at']);

        if (!empty($_GET['from']) && isset($_GET['from'])) {
            $model->where('user_created_at>', date('Y-m-d h:i:s', strtotime($_GET['from'])));
        }


        if (!empty($_GET['to']) && isset($_GET['to'])) {
            $model->where('user_created_at<', date('Y-m-d h:i:s', strtotime($_GET['to'])));
        }

        if (isset($_GET['mobile']) && !empty($_GET['mobile']))
            $model->where('mobile', trim($_GET['mobile']));

        if (isset($_GET['status']) && !empty($_GET['status']))
            $model->where('user_status', trim($_GET['status']));

        $data['users'] = $model->where(['user_detele_status' => 0])->orderBy('uid', 'DESC')->paginate(500);
        $data['pager'] = $model->pager;
        return view('admin/common/header') . view('admin/common/menubar') . view('admin/users', $data) . view('admin/common/footer');
    }

    public function wallet_transactions($userId = '')
    {
        $model = new ApplicationModel('wallet_transactions', 'wid');
        $data['keyStats'] = $model->select(['amount_type', 'SUM(amount) total']);
        if ($userId) {
            $data['keyStats']->where('user_id', $userId);
        }
        $data['keyStats'] = $data['keyStats']->groupBy('amount_type')->orderBy('amount_type', 'ASC')->findAll() ?? [];

        $data['keystats_transaction_types'] = $model->select(['transaction_type', 'SUM(amount) total']);
        if ($userId) {
            $data['keystats_transaction_types']->where('user_id', $userId);
        }
        $data['keystats_transaction_types'] = $data['keystats_transaction_types']->groupBy('transaction_type')->orderBy('transaction_type', 'ASC')->findAll() ?? [];

        $model->select(['user_name', 'mobile', 'email', 'amount', 'amount_type', 'transaction_type', 'before_balance', 'after_balance', 'wallet_created_at'])->join('users', 'wallet_transactions.user_id=users.uid');

        if (!empty($_GET['from']) && isset($_GET['from'])) {
            $model->where('user_created_at>', date('Y-m-d h:i:s', strtotime($_GET['from'])));
        }


        if (!empty($_GET['to']) && isset($_GET['to'])) {
            $model->where('user_created_at<', date('Y-m-d h:i:s', strtotime($_GET['to'])));
        }

        if (isset($_GET['mobile']) && !empty($_GET['mobile']))
            $model->where('mobile', trim($_GET['mobile']));

        if (isset($_GET['status']) && !empty($_GET['status']))
            $model->where('user_status', trim($_GET['status']));

        $data['transactions'] = $model->orderBy('wid', 'DESC')->paginate(500);
        $data['pager'] = $model->pager;
        return view('admin/common/header') . view('admin/common/menubar') . view('admin/wallet-transaction', $data) . view('admin/common/footer');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function game_history()
    {
        $data = [];
        $model = new ApplicationModel('lobbies', 'lid');

        $model->select(['room_id', 'per_head_amt', 'wining_amt', 'service_amt', 'lobby_status', 'lobby_created_at', 'lid']);

        if (!empty($_GET['from']) && isset($_GET['from'])) {
            $model->where('lobby_created_at>', date('Y-m-d h:i:s', strtotime($_GET['from'])));
        }


        if (!empty($_GET['to']) && isset($_GET['to'])) {
            $model->where('lobby_created_at<', date('Y-m-d h:i:s', strtotime($_GET['to'])));
        }

        if (isset($_GET['mobile']) && !empty($_GET['mobile'])) {
            $mobile = trim($_GET['mobile']);
            $model->whereIn('lid', function (BaseBuilder $builder) use ($mobile) {
                return $builder->select('lobby_id')->from('players')->join('players', 'users.uid=players.user_id')->where('mobile', $mobile);
            });
        }


        if (isset($_GET['status']) && !empty($_GET['status']))
            $model->where('lobby_status', trim($_GET['status']));

        $data['lobby_status'] = ['Ongoing', 'Ongoing', 'Winner Declared', 'On Hold'];
        $data['games'] = $model->orderBy('lid', 'DESC')->paginate(500);
        $data['pager'] = $model->pager;
        return view('admin/common/header') . view('admin/common/menubar') . view('admin/game-history', $data) . view('admin/common/footer');
    }

    public function getDetail($lobby = false)
    {
        if ($this->request->isAJAX()) {
            $model = new ApplicationModel('lobbies', 'lid');
            $detail = $model->select(['lid', 'room_id', 'per_head_amt', 'wining_amt', 'service_amt', 'lobby_status', 'lobby_created_at'])->where('room_id', $lobby)->first() ?? [];
            if (!$detail) {
                return $this->response->setJSON(['status' => false, 'message' => 'Room does not exits.']);
            }
            if ($detail['lobby_status'] == 2) {
                $winnerModel = new ApplicationModel('winner', 'win_id');
                $winnerDetail = $winnerModel->select(['user_name', 'mobile'])->join('users', 'users.uid=winner.lid')->where(['lobby_id' => $detail['lid']])->first() ?? [];
                $detail['winner_name'] = $winnerDetail['user_name'] ?? '';
                $detail['winner_mobile'] = $winnerDetail['mobile'] ?? '';
                return $this->response->setJSON(['status' => true, 'message' => 'Winner declared.', 'data' => $detail]);
            }
            $playerModel = new ApplicationModel('players', 'pid');
            $players = $playerModel->select(['user_name', 'mobile', 'user_id', '(CASE WHEN players.user_image IS NOT NULL THEN CONCAT("' . base_url() . '",players.user_image) ELSE players.user_image END) lobby_image'])->join('users', 'players.user_id=users.uid')->where(['lobby_id' => $detail['lid']])->findAll() ?? [];
            $detail['players'] = $players;
            return $this->response->setJSON(['status' => true, 'message' => 'Room Detail fetch.', 'data' => $detail]);
        }
        return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'The request action not allowed.'], true);
    }

    public function changeRoomStatus($lobby = false)
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {
                $rules = [
                    'ch_status' => 'required|in_list[0,2,3]',
                ];
                if ($this->request->getVar('ch_status') == '2') {
                    $rules['winner'] = 'required|numeric';
                }
                $errors = [
                    'ch_status' => [
                        'required' => 'Status is required.',
                        'in_list' => 'Choose status is not valid option.'
                    ],
                    'winner' => [
                        'required' => 'Winner Player is required',
                        'numeric' => 'Choose winner is not valid.'
                    ]
                ];
                if (!$this->validate($rules, $errors)) {
                    return $this->response->setJSON(['message' => 'Validation error occurs', 'status' => false, 'formErrors' => $this->validator->getErrors()]);
                } else {
                    $postData = $this->request->getPost();
                    $model = new ApplicationModel('lobbies', 'lid');
                    $detail = $model->select(['lid', 'lobby_status', 'wining_amt'])->where('room_id', $lobby)->first() ?? [];
                    if (!$detail) {
                        return $this->response->setJSON(['status' => false, 'message' => 'Room does not exits.']);
                    }
                    if ($detail['lobby_status'] == 2) {
                        return $this->response->setJSON(['status' => false, 'message' => 'Room winner already declared.']);
                    }
                    $playerModel = new ApplicationModel('players', 'pid');
                    $playerList = $playerModel->where(['lobby_id' => $detail['lid']])->findColumn('user_id');

                    if (!$playerList) {
                        return $this->response->setJSON(['status' => false, 'message' => 'Room players not exits.']);
                    }

                    if ($postData['ch_status'] == 2) {
                        if (in_array($postData['winner'] ?? '', $playerList) == false) {
                            return $this->response->setJSON(['status' => false, 'message' => 'Choose winner does not exits in room.']);
                        }

                        $winnerModel = new ApplicationModel('winner', 'win_id');
                        $x = $winnerModel->insert(['lobby_id' => $detail['lid'], 'user_id' => $postData['winner']]);
                        if ($x) {
                            $y = $model->update($detail['lid'], ['lobby_status' => 2]);
                            if ($y) {
                                $wallet = $this->crTransaction($postData['winner'], $detail['wining_amt'], 'wining_amount');
                                if ($wallet['status']) {
                                    return $this->response->setJSON(['status' => true, 'message' => 'Winner choose successfully.', 'data' => $postData]);
                                } else {
                                    $model->update($detail['lid'], ['lobby_status' => $detail['lobby_status']]);
                                }
                            }
                            $winnerModel->delete($x);
                        }
                    } else {
                        $y = $model->update($detail['lid'], ['lobby_status' => $postData['ch_status']]);
                        if ($y)
                            return $this->response->setJSON(['status' => true, 'message' => 'Room status successfully changed.', 'data' => $postData]);
                    }

                    return $this->response->setJSON(['status' => false, 'message' => 'Please contact to IT Support.']);
                }
            }
        }
        return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'The request action not allowed.'], true);
    }

    public function setting()
    {
        $data = [];
        $settingModel = new ApplicationModel('settings', 'sid');
        $detail = $settingModel->select(['setting_key', 'setting_value', 'sid'])->where(['setting_key' => 'service_charge'])->first() ?? [];

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'service_charge' => ['label' => 'Service Charges', 'rules' => 'required|numeric|max_length[4]|min_length[1]'],
                'min_amount' => ['label' => 'Minimum Amount', 'rules' => 'required|numeric|max_length[3]'],
                'max_amount' => ['label' => 'Maximum Amount', 'rules' => 'required|numeric|greater_than[{min_amount}]'],
            ];
            // $errors = [
            //     'service_charge' => [
            //         'required' => 'Service charge is required.',
            //         'numeric' => 'Service charge has been only accept digits.',
            //         'max_length' => 'Service charge has been only maximum 5 digits.',
            //         'min_length' => 'Service charge has been only mininum 1 digits.'
            //     ]
            // ];
            if (!$this->validate($rules)) {
                session()->setFlashdata('toastr', ['error' => 'Validation Error Occurs.']);
                return redirect()->withInput()->back();
            } else {
                $postData = $this->request->getPost();
                $settingData = [
                    'setting_value' => json_encode([
                        'charges' => $postData['service_charge'] ?? 0,
                        'min_amount' => $postData['min_amount'] ?? 0,
                        'max_amount' => $postData['max_amount'] ?? 0
                    ]),
                    'setting_key' => 'service_charge'
                ];
                if ($detail) {
                    $settingData['sid'] = $detail['sid'];
                }
                $x = $settingModel->save($settingData);
                if ($x) {
                    session()->setFlashdata('toastr', ['success' => 'Successfully updated.']);
                    return redirect()->back();
                } else {
                    session()->setFlashdata('toastr', ['error' => 'Internal server error occurs. Contact to IT support.']);
                    return redirect()->withInput()->back();
                }
            }
        }
        $data['detail'] = json_decode($detail['setting_value'] ?? '{}', true);
        return view('admin/common/header') . view('admin/common/menubar') . view('admin/game-setting', $data) . view('admin/common/footer');
    }
}
