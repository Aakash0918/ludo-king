<?php

namespace App\Controllers;

use App\Models\ApplicationModel;
use CodeIgniter\HTTP\Request;

class Home extends BaseController
{
    public function index()
    {
        $data = [];
        return view('frontend/home', $data);
    }
    public function dashboard()
    {
        $data = [];
        $data['pagename'] = 'frontend/dashboard';
        return view('frontend/index', $data);
    }

    public function profile()
    {
        $data = [];
        $data['pagename'] = 'frontend/profile';
        return view('frontend/index', $data);
    }

    public function battles()
    {
        if (!session('isLogin')) {
            return redirect()->to(base_url('login?redUrl=' . base_url('home/battles')));
        }
        $data = [];
        $model = new ApplicationModel('game_pools', 'gp_id');
        $data['battles'] = $model->select(['unique_id', 'pool_price', 'winning_price', 'capacity', 'gp_type', 'live_users'])->where(['gp_delete_status' => 0, 'gp_status' => 1])->orderBy('pool_price', 'ASC')->findAll();
        $data['pagename'] = 'frontend/battles';
        return view('frontend/index', $data);
    }

    public function logout()
    {
        if (!session('isLogin')) {
            return redirect()->to(base_url('login'));
        }
        session()->remove(['isLogin', 'name', 'mobile', 'email']);
        return redirect()->to('/login');
    }

    public function term_condition()
    {
        $data = [];
        $data['pagename'] = 'frontend/term-condition';
        return view('frontend/index', $data);
    }
    public function privacy_policy()
    {
        $data = [];
        $data['pagename'] = 'frontend/privacy-policy';
        return view('frontend/index', $data);
    }
    public function refund_policy()
    {
        $data = [];
        $data['pagename'] = 'frontend/refund-policy';
        return view('frontend/index', $data);
    }
    public function platform_commission()
    {
        $data = [];
        $data['pagename'] = 'frontend/platform-commission';
        return view('frontend/index', $data);
    }
    public function responsible_gaming()
    {
        $data = [];
        $data['pagename'] = 'frontend/responsible-gaming';
        return view('frontend/index', $data);
    }
    public function tds_policy()
    {
        $data = [];
        $data['pagename'] = 'frontend/tds-policy';
        return view('frontend/index', $data);
    }
    public function contact_us()
    {
        $data = [];
        $data['setting'] = cache('support_setting');
        $data['pagename'] = 'frontend/contact-us';
        return view('frontend/index', $data);
    }

    public function page_not_found()
    {
        $data = [];
        return view('404', $data);
    }

    public function waiting_for_player($uniqueId = '')
    {
        if ($uniqueId == '') {
            session()->setFlashdata('toastr', ['error' => 'Battle is not exits.']);
            return redirect()->back();
        }
        if (!session('isLogin')) {
            return redirect()->to(base_url('login?redUrl=' . base_url('home/waiting-for-player/' . $uniqueId)));
        }
        $model = new ApplicationModel('game_pools', 'gp_id');
        $poolDetail = $model->select(['unique_id', 'pool_price', 'winning_price', 'gp_id', 'capacity'])->where(['unique_id' => $uniqueId, 'gp_status' => 1, 'gp_delete_status' => 0])->first() ?? [];
        if (!$poolDetail) {
            session()->setFlashdata('toastr', ['error' => 'Battle is not exits/suspended.']);
            return redirect()->back();
        }
        $data = [];
        // check wallet balance here
        if ($poolDetail['pool_price'] > availableBalance()) {
            session()->setFlashdata('toastr', ['error' => 'Insuffient Balance to start game.']);
            return redirect()->to('/home/battles');
        }

        $amount = $poolDetail['pool_price'];
        $encrypter = \Config\Services::encrypter();
        $plainText  = json_encode(['user_id' => session('id'), 'amount' => $amount, 'pool_id' => $poolDetail['gp_id'], 'winning_amount' => $poolDetail['winning_price'], 'unique_id' => $uniqueId]);
        $ciphertext = $encrypter->encrypt($plainText);
        $data['cipherText'] = urlencode(bin2hex($ciphertext));
        // deduct wallet amount here
        return view('frontend/waiting-for-player', $data);
    }

    public function my_wallet()
    {
        if (!session('isLogin')) {
            return redirect()->to(base_url('login?redUrl=' . base_url('home/my-wallet')));
        }
        $data = [];
        $data['pagename'] = 'frontend/my-wallet';
        return view('frontend/index', $data);
    }

    public function withdraw_wallet()
    {
        if (!session('isLogin')) {
            return redirect()->to(base_url('login?redUrl=' . base_url('home/withdraw-wallet')));
        }
        $data['pagename'] = 'frontend/withdraw';
        return view('frontend/index', $data);
    }

    public function add_wallet()
    {
        if (!session('isLogin')) {
            return redirect()->to(base_url('login?redUrl=' . base_url('home/add-wallet')));
        }
        $mimAmount = 10;
        $maxAmount = 1000000;
        $frequentOption = ['50', '100', '200', '500', '1000'];
        $data = [];
        $data['min_amount'] = $mimAmount;
        $data['max_amount'] = $maxAmount;
        $data['frequentOption'] = $frequentOption;
        $data['pagename'] = 'frontend/add-wallet';
        return view('frontend/index', $data);
    }

    public function game_history()
    {
        if (!session('isLogin')) {
            return redirect()->to(base_url('login?redUrl=' . base_url('home/game-history')));
        }
        $data = [];
        $model = new ApplicationModel('lobbies', 'lid');
        $data['games'] = $model->select(['room_id', 'per_head_amt', 'wining_amt', 'lobby_status', 'lobby_created_at', 'winner.user_id win_user'])
            ->join('players', 'lobbies.lid=players.lobby_id', 'left')
            ->join('winner', 'lobbies.lid=winner.lobby_id', 'left')
            ->where('players.user_id', session('id'))->orderBy('lid', 'DESC')->paginate(50);
        $data['lobby_status'] = ['Ongoing', 'Ongoing', 'Winner Announce', 'On Hold'];
        $data['pager'] = $model->pager;
        $data['pagename'] = 'frontend/game-history';
        return view('frontend/index', $data);
    }

    public function transaction_history()
    {
        if (!session('isLogin')) {
            return redirect()->to(base_url('login?redUrl=' . base_url('home/transaction-histroy')));
        }
        $data = [];
        $model = new ApplicationModel('wallet_transactions', 'wid');
        $data['transactions'] = $model->select(['amount', 'amount_type', 'transaction_type', 'before_balance', 'after_balance', 'is_withdrawable', 'wallet_created_at'])->where('user_id', session('id'))->orderBy('wid', 'DESC')->paginate(50);
        $data['pager'] = $model->pager;
        $data['pagename'] = 'frontend/transaction-history';
        return view('frontend/index', $data);
    }

    public function complete_kyc()
    {
        if (!session('isLogin')) {
            return redirect()->to(base_url('login?redUrl=' . base_url('home/complete-kyc')));
        }
        if (session('kyc')) {
            session()->setFlashdata('toastr', ['info' => 'KYC Already completed.']);
            return redirect()->withInput()->back();
        }
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'type' => 'required|in_list[pancard,aadhar_card]',
            ];
            if ($this->request->getVar('type') == 'aadhar_card') {
                $exactLen = 12;
                $rules['id_proof'] = 'required|numeric|exact_length[12]|regex_match[/^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$/]';
            } else {
                $exactLen = 10;
                $rules['id_proof'] = 'required|alpha_numeric|exact_length[10]|regex_match[/[A-Z]{5}[0-9]{4}[A-Z]{1}/]';
            }
            $errors = [
                'type' => [
                    'required' => 'Document type is required.',
                    'in_list' => 'Choose document type is not valid.'
                ],
                'id_proof' => [
                    'required' => 'Id Proof is required.',
                    'numeric' => 'Id proof has been support only digits.',
                    'alpha_numeric' => 'Id proof has been support only characters digits.',
                    'exact_length' => "Id proof has been support exact length is " . $exactLen . ' characters.',
                    'regex_match' => 'Id proof is not valid.'
                ]
            ];
            if (!$this->validate($rules, $errors)) {
                session()->setFlashdata('toastr', ['error' => 'Validation error occurs.']);
                return redirect()->withInput()->back();
            } else {
                $postData = $this->request->getPost();
                $kycData = [
                    'document_type' => $postData['type'],
                    'document_id' => $postData['id_proof']
                ];
                $kycModel = new ApplicationModel('kyc_details', 'kid');
                $x = $kycModel->insert($kycData);
                if ($x) {
                    $model =  new ApplicationModel('users', 'uid');
                    $y = $model->set('kyc_id', $x)->where(['uid' => session('id')])->update();
                    if ($y) {
                        session()->set('kyc', $x);
                        session()->setFlashdata('toastr', ['success' => 'Kyc done successfully.']);
                        return redirect()->to('/home/battles');
                    } else {
                        $kycModel->delete($x);
                        session()->setFlashdata('toastr', ['error' => 'Something went wrong. Please contact to support.']);
                        return redirect()->withInput()->back();
                    }
                } else {
                    session()->setFlashdata('toastr', ['error' => 'Something went wrong. Please contact to support.']);
                    return redirect()->withInput()->back();
                }
            }
        }
        $data['pagename'] = 'frontend/kyc-detail';
        return view('frontend/index', $data);
    }

    public function game_rules()
    {
        $data['pagename'] = 'frontend/rules';
        return view('frontend/index', $data);
    }

    public function notification()
    {
        $data['pagename'] = 'frontend/notification';
        return view('frontend/index', $data);
    }

    public function support()
    {
        $data['pagename'] = 'frontend/supports';
        return view('frontend/index', $data);
    }

    public function refer_earn()
    {
        $data['pagename'] = 'frontend/refer-earn';
        return view('frontend/index', $data);
    }

    public function profile_edit()
    {
        if (!session('isLogin')) {
            return redirect()->to(base_url('login?redUrl=' . base_url('home/complete-kyc')));
        }

        $data['pagename'] = 'frontend/profile-edit';
        return view('frontend/index', $data);
    }

    public function submit_profile()
    {
        if ($this->request->isAJAX()) {
            if (!session('isLogin')) {
                return $this->response->setJSON(['redUrl' => base_url('login?redUrl=' . base_url('home/complete-kyc')), 'status' => false, 'auth' => false], true);
            }
            if ($this->request->getMethod() == 'post') {
                $rules = [
                    'name' => 'required|min_length[3]|max_length[255]',
                    'email' => 'required|valid_email',
                ];
                if ($this->request->getFile('image')->getName() != '') {
                    $rules['image'] = 'uploaded[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,300]';
                }
                $errors = [
                    'name' => [
                        'required' => 'Name is required.',
                        'min_length' => 'Name has been support minimum 3 characters.',
                        'max_length' => 'Name has been support maximum 255 characters.',
                    ],
                    'email' => [
                        'required' => 'Email is required.',
                        'valid_email' => 'Email is not valid.'
                    ],
                    'image' => [
                        'uploaded' => 'Image is required.',
                        'mime_in' => 'Image is not valid format.(jpg,jpeg,png).',
                        'max_size' => 'Image has been support maximum size 256kb.'
                    ]
                ];
                if (!$this->validate($rules, $errors)) {
                    return $this->response->setJSON(['message' => 'Validation error occurs.', 'formErrors' => $this->validator->getErrors(), 'status' => false], true);
                } else {
                    $postData = $this->request->getPost();
                    $profileData = [
                        'user_name' => $postData['name'],
                        'email' => $postData['email']
                    ];
                    if ($this->request->getFile('image')->getName() != '') {
                        $img = $this->request->getFile('image');
                        if ($img->isValid() && !$img->hasMoved()) {
                            $newName = $img->getRandomName();
                            $img->move('./assets/uploads/profile/', $newName);
                            $path = '/assets/uploads/profile/' . $newName;
                            $profileData['user_image'] = $path;
                            session()->set('image', base_url($path));
                        }
                    } else {
                        $path = session('image');
                    }
                    $model = new ApplicationModel('users', 'uid');
                    $x = $model->set($profileData)->where('uid', session('id'))->update();
                    if ($x) {
                        session()->set('name', $postData['name']);
                        session()->set('email', $postData['email']);
                        return $this->response->setJSON(['message' => 'Profile Successfully updated.', 'status' => true, 'image' => session('image')], true);
                    }
                }
            }
        }
        return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'The request action not allowed.'], true);
    }

    public function room_code($roomId = false)
    {
        if (!session('isLogin')) {
            return redirect()->to(base_url('login?redUrl=' . base_url('home/room-code/' . $roomId)));
        }
        $lobbyModel = new ApplicationModel('lobbies', 'lid');
        $check = $lobbyModel->select(['room_id', 'lobby_status status', 'lid lobby', 'user_image'])->join('players', 'lobbies.lid=players.lobby_id')->where(['room_id' => $roomId, 'user_id' => session('id')])->first();
        if (!$check) {
            session()->setFlashdata('toastr', ['error' => 'Room does not exit.']);
            return redirect()->to(base_url('home/battles'));
        }
        $data['room_detail'] = $check;
        $data['pagename'] = 'frontend/room-code';
        return view('frontend/index', $data);
    }

    public function submitScreenshot($roomId = false)
    {
        if ($this->request->isAJAX()) {
            if (!session('isLogin')) {
                return $this->response->setJSON(['redUrl' => base_url('login?redUrl=' . base_url('home/room-code/' . $roomId)), 'status' => false, 'auth' => false], true);
            }
            if ($this->request->getMethod() == 'post') {
                $rules = [
                    'image' => 'uploaded[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,300]',
                    'room' => 'required|numeric',
                ];

                $errors = [
                    'room' => [
                        'required' => 'Something went wrong try again after sometime.',
                        'numeric' => 'Something went wrong try again after sometime.',
                    ],
                    'image' => [
                        'uploaded' => 'Screenshot is required.',
                        'mime_in' => 'Screenshot is not valid format.(jpg,jpeg,png).',
                        'max_size' => 'Screenshot has been support maximum size 256kb.'
                    ]
                ];
                if (!$this->validate($rules, $errors)) {
                    return $this->response->setJSON(['message' => 'Validation error occurs.', 'formErrors' => $this->validator->getErrors(), 'status' => false], true);
                } else {
                    $postData = $this->request->getPost();
                    if ($roomId != ($postData['room'] ?? '')) {
                        return $this->response->setJSON(['message' => 'Validation error occurs.', 'formErrors' => ['room' => 'Something went wrong try again after some time.'], 'status' => false], true);
                    }
                    $lobbyModel = new ApplicationModel('lobbies', 'lid');
                    $checkLobby = $lobbyModel->select(['lid', 'lobby_status'])->where(['room_id' => $postData['room']])->first();
                    if (!$checkLobby) {
                        return $this->response->setJSON(['message' => 'Validation error occurs.', 'formErrors' => ['room' => 'Room does not exits.'], 'status' => false], true);
                    }
                    if (in_array($checkLobby['lobby_status'], ['2', '3'])) {
                        return $this->response->setJSON(['message' => 'Validation error occurs.', 'formErrors' => ['room' => 'Result has been declare or hold.'], 'status' => false], true);
                    }
                    $playerModel = new ApplicationModel('players', 'pid');
                    $check = $playerModel->select(['pid', 'user_image'])->where(['lobby_id' => $checkLobby['lid'], 'user_id' => session('id')])->first();
                    if (!$check) {
                        return $this->response->setJSON(['message' => 'Validation error occurs.', 'formErrors' => ['room' => 'Room player does not exits.'], 'status' => false], true);
                    }
                    if ($check['user_image']) {
                        return $this->response->setJSON(['message' => 'Validation error occurs.', 'formErrors' => ['image' => 'Screenshot already uploaded.'], 'status' => false], true);
                    }
                    $img = $this->request->getFile('image');
                    if ($img->isValid() && !$img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $y = $img->move('./assets/uploads/game/', $newName);
                        if ($y) {
                            $path = '/assets/uploads/game/' . $newName;
                            $imageData['user_image'] = $path;
                            $x = $playerModel->set($imageData)->where(['lobby_id' => $checkLobby['lid'], 'user_id' => session('id')])->update();
                            if ($x) {
                                return $this->response->setJSON(['message' => 'Screenshot successfully uploaded.', 'status' => true, 'image' => base_url($path)], true);
                            }
                        }
                    }
                    return $this->response->setStatusCode(500)->setJSON(['status' => false, 'message' => 'Something Went wrong. Please contact to support.'], true);
                }
            }
        }
        return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'The request action not allowed.'], true);
    }

    public function betting()
    {
        if (!session('isLogin')) {
            return redirect()->to(base_url('login?redUrl=' . base_url('home/betting')));
        }
        $settingModel = new ApplicationModel('settings', 'sid');
        $detail = $settingModel->select(['setting_value'])->where(['setting_key' => 'service_charge'])->first() ?? [];
        $data['detail'] = json_decode($detail['setting_value'] ?? '{}', true);

        $data['pagename'] = 'frontend/custum-betting';
        return view('frontend/index', $data);
    }

    public function submit_bet_now()
    {

        if ($this->request->isAJAX()) {
            if (!session('isLogin')) {
                return $this->response->setJSON(['redUrl' => base_url('login?redUrl=' . base_url('home/betting/')), 'status' => false, 'auth' => false], true);
            }
            if ($this->request->getMethod() == 'post') {
                $settingModel = new ApplicationModel('settings', 'sid');
                $detail = $settingModel->select(['setting_value'])->where(['setting_key' => 'service_charge'])->first() ?? [];
                $detail = json_decode($detail['setting_value'] ?? "{}", true);
                $platform = $detail['charges'] ?? 0;
                $min_amount = $detail['min_amount'] ?? 100;
                $max_amount = $detail['max_amount'] ?? 100;
                $rules = [
                    'amount' => 'required|numeric|greater_than_equal_to[' . $min_amount . ']|less_than_equal_to[' . $max_amount . ']'
                ];
                $errors = [
                    'amount' => [
                        'required' => 'Amount is required.',
                        'numeric' => 'Amount has been support only digits.',
                        'greater_than_equal_to' => 'Amount should be greater than or equal to ' . $min_amount . '.',
                        'less_than_equal_to' => 'Amount should be less than or equal to ' . $max_amount . '.',
                    ]
                ];
                if (!$this->validate($rules, $errors)) {
                    return $this->response->setJSON(['message' => 'Validation error occurs.', 'formErrors' => $this->validator->getErrors(), 'status' => false], true);
                } else {
                    $postData = $this->request->getPost();
                    $poolPrize = round($postData['amount'] * 2, 2);
                    $platformAmt = round($poolPrize * ($platform / 100), 2);
                    $winingPrize = round($poolPrize - $platformAmt, 2);
                    $gamePoolModel = new ApplicationModel('game_pools', 'gp_id');
                    $gameData = [
                        'pool_price' => number_format($postData['amount'], 2, '.', ''),
                        'winning_price' => number_format($winingPrize, 2, '.', ''),
                        'gp_type' => 0,
                        'capacity' => 2,
                    ];
                    $check = $gamePoolModel->select(['unique_id', 'gp_status', 'gp_id', 'gp_delete_status'])->where($gameData)->first();
                    if ($check) {
                        $x = true;
                        if ($check['gp_status'] == 0 || $check['gp_delete_status'] == 0) {
                            $gameData['gp_id'] = $check['gp_id'];
                            $gameData['gp_status'] = 1;
                            $gameData['gp_delete_status'] = 0;
                            $x = $gamePoolModel->save($gameData);
                        }
                        if ($x) {
                            return $this->response->setJSON(['message' => 'Add successfully.',  'status' => true, 'redUrl' => base_url('home/waiting-for-player/' . $check['unique_id'])], true);
                        } else {
                            return $this->response->setStatusCode(500)->setJSON(['message' => 'Internal Server error occurs. Kindly contact to IT Support Team.', 'status' => false], true);
                        }
                    }
                    $gameData['gp_status'] = 1;
                    $uniqueId = uniqid('GP');
                    $gameData['unique_id'] = $uniqueId;
                    $x = $gamePoolModel->insert($gameData);
                    if ($x) {
                        return $this->response->setJSON(['message' => 'Add successfully.',  'status' => true, 'redUrl' => base_url('home/waiting-for-player/' . $uniqueId)], true);
                    } else {
                        return $this->response->setStatusCode(500)->setJSON(['message' => 'Internal Server error occurs. Kindly contact to IT Support Team.', 'status' => false], true);
                    }
                }
            }
        }
        return $this->response->setStatusCode(404)->setJSON(['status' => false, 'message' => 'The request action not allowed.'], true);
    }
}
