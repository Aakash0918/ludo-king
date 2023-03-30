<?php

namespace App\Controllers;

use App\Models\ApplicationModel;

class Admin extends BaseController
{

    /******************* Login Start *******************/

    public function index()
    {
        return view('admin/login');
    }

    /******************* Login End *******************/

    public function battles()
    {
        return view('admin/common/header') . view('admin/common/menubar') . view('admin/battles') . view('admin/common/footer');
    }
    public function addbattle()
    {
        return view('admin/common/header') . view('admin/common/menubar') . view('admin/addbattles') . view('admin/common/footer');
    }
    public function logout()
    {
        if (!session('isLoggedIn'))
            return redirect()->to('/');
        session()->destroy();
        return redirect()->to('/');
    }


}
