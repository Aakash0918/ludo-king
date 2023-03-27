<?php

namespace App\Controllers;

use App\Models\ApplicationModel;

class Login extends BaseController
{
    public function index()
    {
        if (session('isLogin')) {
            return redirect()->back();
        }
        $data = [];
        return view('frontend/login', $data);
    }

    public function send_otp()
    {
        if (session('isLogin')) {
            return redirect()->back();
        }
        if ($this->request->isAJAX()) {
            if ($this->request->getMethod() == 'post') {
                $rules = [
                    'mobile' => 'required|numeric|exact_length[10]|regex_match[/^[+]?[1-9][0-9]{9,14}$/]'
                ];
                $errors = [
                    'mobile' => [
                        'required' => 'Mobile number is required.',
                        'numeric' => 'Mobile number has been support only digits.',
                        'exact_length' => 'Mobile number has been support only 10 digits only.',
                        'regex_match' => 'Mobile number is not valid.'
                    ]
                ];
                if (!$this->validate($rules, $errors)) {
                    return $this->response->setJSON(['message' => 'Validation error occurs.', 'formErrors' => $this->validator->getErrors(), 'status' => false], true);
                } else {
                    $postData = $this->request->getPost();
                    $userModel = new ApplicationModel('users', 'uid');
                    $check  = $userModel->select(['uid', 'user_status', 'user_detele_status'])->where(['mobile' => $postData['mobile'] ?? ''])->first();
                    $otp = random_string('nozero', 6);
                    $otp_expire = time() * 6 * 60;
                    $userData = [
                        'mobile' => $postData['mobile'],
                        'otp' => $otp,
                        'otp_expire' => $otp_expire,
                    ];
                    $newBee = false;
                    if ($check) {
                        if ($check['user_detele_status'] == '1') {
                            return $this->response->setJSON(['message' => 'Validation error occurs.', 'formErrors' => ['mobile' => 'Mobile number has been dectivated.'], 'status' => false], true);
                        }
                        $userData['uid'] = $check['uid'];
                        $x = $userModel->save($userData);
                    } else {
                        $userData['referal_code'] = $this->generateReferalCode();
                        if (($postData['referal_code'] ?? '') != '') {
                            $referalDetail = $userModel->select('uid')->where('referal_code', $postData['referal'])->first() ?? [];
                            if (!$referalDetail) {
                                return $this->response->setJSON(['message' => 'Validation error occurs.', 'formErrors' => ['referal_code' => 'Referal code is not valid.'], 'status' => false], true);
                            }
                            // check maximum referal limit here
                            $userData['referal_by'] = $referalDetail['uid'];
                        }
                        $x = $userModel->insert($userData);
                    }
                    if ($x) {
                        // send Otp Here
                        $mobile = $postData['mobile'];
                        $message = "[" . APP_NAME . "] your otp is " . $otp . ". It valid for 5 minutes only.";
                        $y = $this->sendSms($mobile, $message);
                        if ($y) {
                            return $this->response->setJSON(['message' => 'OTP has been send on the xxx-xxx-' . substr($postData['mobile'], 6, 4), 'status' => true, 'newBee' => $newBee], true);
                        } else {
                            return $this->response->setStatusCode(500)->setJSON(['message' => 'Internal Server Errors.', 'status' => false], true);
                        }
                    } else {
                        return $this->response->setStatusCode(500)->setJSON(['message' => 'Internal Server Errors.', 'status' => false], true);
                    }
                }
            }
        }
        return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'The request action not allowed.'], true);
    }

    public function otp_verify()
    {
        if (session('isLogin')) {
            return redirect()->back();
        }
        if ($this->request->isAJAX()) {
            $rules = [
                'mobile' => 'required|numeric|exact_length[10]|regex_match[/^[+]?[1-9][0-9]{9,14}$/]',
                'otp' => 'required|numeric|exact_length[6]'
            ];
            $errors = [
                'mobile' => [
                    'required' => 'Mobile number is required.',
                    'numeric' => 'Mobile number has been support only digits.',
                    'exact_length' => 'Mobile number has been support only 10 digits only.',
                    'regex_match' => 'Mobile number is not valid.'
                ],
                'otp' => [
                    'required' => 'OTP is required.',
                    'numeric' => 'OTP has been support only digits.',
                    'exact_length' => 'OTP has been support only 6 digits only.',
                ]
            ];
            if (!$this->validate($rules, $errors)) {
                return $this->response->setJSON(['message' => 'Validation error occurs.', 'formErrors' => $this->validator->getErrors(), 'status' => false], true);
            } else {
                $postData = $this->request->getPost();
                $userModel = new ApplicationModel('users', 'uid');
                $check  = $userModel->select(['uid', 'user_status', 'user_detele_status', 'otp', 'otp_expire', 'user_name', 'email', 'referal_by'])->where(['mobile' => $postData['mobile'] ?? ''])->first();
                if (!$check) {
                    return $this->response->setJSON(['message' => 'Validation error occurs.', 'formErrors' => ['mobile' => 'Mobile number has been not register.'], 'status' => false], true);
                }
                if ($check['user_detele_status'] == '1') {
                    return $this->response->setJSON(['message' => 'Validation error occurs.', 'formErrors' => ['mobile' => 'Mobile number has been dectivated.'], 'status' => false], true);
                }
                // verify otp here
                if (time() > $check['otp_expire']) {
                    return $this->response->setJSON(['message' => 'Validation error occurs.', 'formErrors' => ['otp' => 'OTP has been expired.'], 'status' => false], true);
                }
                if ($postData['otp'] != $check['otp']) {
                    return $this->response->setJSON(['message' => 'Validation error occurs.', 'formErrors' => ['otp' => 'OTP does not match.'], 'status' => false], true);
                }
                $userData = [
                    'uid' => $check['uid'],
                    'otp_expire' => time(),
                ];
                if ($check['user_status'] == '0') {
                    // apply new user action here
                    if ($check['referal_by']) {
                        //transfer money here
                        $referalAmount = 30;
                    }
                    $userData['user_status'] = 1;
                }
                $x = $userModel->save($userData);
                if ($x) {
                    //set session here
                    $this->setSessionData($check);
                    return $this->response->setJSON(['message' => 'Login Successfully', 'redUrl' => base_url(), 'status' => true], true);
                } else {
                    return $this->response->setStatusCode(500)->setJSON(['message' => 'Internal Server Errors.', 'status' => false], true);
                }
            }
        }
        return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'The request action not allowed.'], true);
    }

    protected function setSessionData($data)
    {
        $sessionData = [
            'isLogin' => true,
            'name' => $data['user_name'],
            'mobile' => $data['mobile'],
            'email' => $data['email']
        ];
        session()->set($sessionData);
        return true;
    }
}
