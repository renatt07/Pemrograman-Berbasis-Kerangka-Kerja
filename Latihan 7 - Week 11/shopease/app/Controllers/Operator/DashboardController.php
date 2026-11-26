<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('operator/dashboard', [
            'title'      => 'Dashboard Operator — ShopEase',
            'activeMenu' => 'operator',
        ]);
    }
}