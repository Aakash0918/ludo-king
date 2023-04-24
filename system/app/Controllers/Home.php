<?php

namespace App\Controllers;

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
        $data = [];
        $data['pagename'] = 'frontend/battles';
        return view('frontend/index', $data);
    }

    public function logout()
    {
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
        $data['pagename'] = 'frontend/contact-us';
        return view('frontend/index', $data);
    }

    public function page_not_found()
    {
        $data = [];
        return view('404', $data);
    }
}
