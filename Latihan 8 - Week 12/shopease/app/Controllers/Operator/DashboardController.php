<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\ProductModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $orderModel   = new OrderModel();
        $productModel = new ProductModel();

        $readyToShip = $orderModel
            ->select('orders.*, users.name AS customer_name, shipments.courier, shipments.tracking_number')
            ->join('users', 'users.id_user = orders.id_user')
            ->join('shipments', 'shipments.id_order = orders.id_order', 'left')
            ->whereIn('orders.order_status', ['processing', 'shipped'])
            ->orderBy('orders.id_order', 'DESC')
            ->findAll(10);

        return view('operator/dashboard', [
            'title'           => 'Dashboard Operator — ShopEase',
            'activeMenu'      => 'operator',
            'processingCount' => $orderModel->where('order_status', 'processing')->countAllResults(),
            'shippedCount'    => $orderModel->where('order_status', 'shipped')->countAllResults(),
            'lowStockCount'   => $productModel->where('stock <=', 5)->countAllResults(),
            'readyToShip'     => $readyToShip,
        ]);
    }
}