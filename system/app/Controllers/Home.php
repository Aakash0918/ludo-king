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
}
