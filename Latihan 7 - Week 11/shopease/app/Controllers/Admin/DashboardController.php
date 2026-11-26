<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        return view('admin/dashboard', [
            'title'          => 'Dashboard Admin — ShopEase',
            'activeMenu'     => 'admin',
            'totalUsers'     => $userModel->countAll(),
            'totalCustomers' => $userModel->where('role', 'customer')->countAllResults(),
            'totalOperators' => $userModel->where('role', 'operator')->countAllResults(),
        ]);
    }
}