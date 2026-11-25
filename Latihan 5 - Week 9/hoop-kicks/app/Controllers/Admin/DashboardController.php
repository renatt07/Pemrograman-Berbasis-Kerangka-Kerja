<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\OrderModel;
use App\Models\ProductModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();
        $orderModel    = new OrderModel();

        $revenueRow = $orderModel->selectSum('total_price')
            ->whereIn('status', ['paid', 'shipped', 'completed'])
            ->first();

        $allOrders = $orderModel->getAllWithCustomer();

        return view('admin/dashboard', [
            'title'            => 'Admin Dashboard',
            'totalProducts'    => $productModel->countAll(),
            'totalCategories'  => $categoryModel->countAll(),
            'totalOrders'      => $orderModel->countAll(),
            'pendingOrders'    => $orderModel->where('status', 'pending')->countAllResults(),
            'totalRevenue'     => (int) ($revenueRow['total_price'] ?? 0),
            'lowStockProducts' => $productModel->where('stock <=', 5)->orderBy('stock', 'ASC')->findAll(),
            'recentOrders'     => array_slice($allOrders, 0, 5),
        ]);
    }
}