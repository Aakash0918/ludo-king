<?php

namespace App\Controllers;

use App\Models\ApplicationModel;
use OpenAPI\Client\ApiException;
use OpenAPI\Client\CFInterface\CFConfig;
use OpenAPI\Client\CFInterface\CFEnvironment;
use OpenAPI\Client\CFInterface\CFHeader;
use OpenAPI\Client\CFInterface\CFPaymentGateway;
use OpenAPI\Client\Model\CFOrderRequest;

class Payment extends BaseController
{

    public function create_order()
    {
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post' && (session('isLogin') || true)) {
                $minAmount = 10;
                $maxAmount = 1000000;
                $rules = [
                    'amount' => 'required|numeric|greater_than_equal_to[' . $minAmount . ']|less_than_equal_to[' . $maxAmount . ']'
                ];
                $errors = [
                    'amount' => [
                        'required' => 'Amount is required.',
                        'numeric' => 'Amount has been support only digits.',
                        'greater_than_equal_to' => 'Amount has support minimum ₹ ' . $minAmount . '.',
                        'less_than_equal_to' => 'Amount has support maximum ' . $maxAmount . '.',
                    ]
                ];
                if (!$this->validate($rules, $errors)) {
                    return $this->response->setJSON(['message' => 'Validation error occurs.', 'formErrors' => $this->validator->getErrors(), 'status' => false], true);
                } else {
                    $postData = $this->request->getPost();
                    $uniqueId = 'order_' . uniqid();
                    $data = [
                        'order_id' => $uniqueId,
                        'order_currency' => 'INR',
                        'order_amount' => $postData['amount'],
                        'customer_details' => [
                            'customer_id' => session('id'),
                            'customer_name' => session('name') ? session('name') : 'Ludo King',
                            'customer_email' => session('email') ? session('email') : 'ludo@gmail.com',
                            'customer_phone' => session('mobile')
                        ],
                        'order_meta' => [
                            'return_url' => 'http://localhost/payment/response/{order_id}',
                            'payment_methods' => 'cc,nb,upi,app,dc,banktransfer'
                        ],
                        // order_tags' => [],
                        // 'order_splits' => []
                        'order_note' => 'some order note here'
                    ];
                    $result = $this->curlRequestCashFree('orders', $data);

                    if ($result['status']) {
                        $paymentRequestModel = new ApplicationModel('payment_requests', 'pid');
                        $paydata = [
                            'unique_id' => $uniqueId,
                            'user_id' => session('id'),
                            'payment_amount' => $postData['amount'],
                            'payment_id' => $result['data']['payment_session_id'],
                            'create_order_resp' => json_encode($result['data']),
                        ];
                        if ($paymentRequestModel->insert($paydata)) {
                            return $this->response->setJSON(['message' => 'Success', 'data' => ['payment_session_id' => $result['data']['payment_session_id']], 'status' => true], true);
                        } else {
                            return $this->response->setJSON(['message' => 'Something went wrong. please try again after time.', 'status' => false], true);
                        }
                    } else {
                        return $this->response->setJSON(['message' => 'Validation error occurs.', 'formErrors' => $result['data'], 'status' => false], true);
                    }
                }
            }
        }
        return $this->response->setJSON(['status' => false, 'message' => 'The requested action is not allowed.']);
    }


    public function response($orderId = '')
    {
        if ($orderId == '') {
            return $this->response->setJSON(['status' => false, 'message' => 'The requested action is not allowed.']);
        }
        $resp = $this->checkStatusCashFree($orderId);

        if ($resp['status']) {
            $paymentModel = new ApplicationModel('payment_requests', 'pid');
            $check = $paymentModel->select(['pid', 'payment_amount', 'user_id'])->where(['unique_id' => $orderId])->first();
            if ($check) {
                $checkApiResponse = $resp['data'];
                $modelPayStatusModel = new ApplicationModel('payment_req_status', 'prs_id');
                $checkStatus = $modelPayStatusModel->select(['prs_id', 'status'])->where(['payment_req_id' => $check['pid']])->first();
                $orderStatus = $checkApiResponse["order_status"] == 'PAID';
                $orderData = ['payment_req_id' => $check['pid'], 'status' => $orderStatus, 'payment_resp' => json_encode($checkApiResponse)];
                if ($checkStatus) {
                    if ($checkStatus['status']) {
                        return redirect()->to('/payment/success/' . $orderId . '?msg="Payment successfull done.');
                    } else {
                        if (!$orderStatus) {
                            return redirect()->to('/payment/fail/' . $orderId . '?msg="Order id not failed.');
                        }
                        $orderData['prs_id'] = $checkStatus['prs_id'];
                    }
                }
                $x = $modelPayStatusModel->save($orderData);
                if ($orderStatus && $x) {
                    $this->crTransaction($check['user_id'], $checkApiResponse['order_amount'], 'add_fund');
                    return redirect()->to('/payment/success/' . $orderId . '?msg="Payment successfull done.');
                } else {
                    return redirect()->to('/payment/fail/' . $orderId . '?msg="Order id not failed.');
                }
            }
        }

        return redirect()->to('/payment/fail/' . $orderId . '?msg=Order id not failed/valid');
    }

    public function success($orderId = '')
    {
        if ($orderId == '') {
            return $this->response->setJSON(['status' => false, 'message' => 'The requested action is not allowed.']);
        }
        $data = [];
        $data['order_id'] = $orderId;
        $data['message'] = $_GET['msg'] ?? 'Invalid Message';
        $data['pagename'] = 'frontend/success';
        return view('frontend/index', $data);
    }

    public function fail($orderId = '')
    {
        if ($orderId == '') {
            return $this->response->setJSON(['status' => false, 'message' => 'The requested action is not allowed.']);
        }
        $data = [];
        $data['order_id'] = $orderId;
        $data['message'] = $_GET['msg'] ?? 'Invalid Message';
        $data['pagename'] = 'frontend/fail';
        return view('frontend/index', $data);
    }
}
