<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Models\ProductModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $userModel    = new UserModel();
        $productModel = new ProductModel();
        $orderModel   = new OrderModel();
        $paymentModel = new PaymentModel();
        $db           = \Config\Database::connect();

        // Total penjualan dari pesanan yang sudah dibayar / diproses / dikirim / selesai
        $salesRow = $db->table('orders')
            ->selectSum('total', 'total_sales')
            ->whereIn('order_status', ['processing', 'shipped', 'completed'])
            ->get()
            ->getRowArray();

        // Data grafik penjualan harian (7 hari terakhir yang ada transaksi)
        $dailySales = $db->table('orders')
            ->select('DATE(created_at) AS tanggal, SUM(total) AS penjualan, COUNT(*) AS jumlah_order')
            ->whereIn('order_status', ['processing', 'shipped', 'completed'])
            ->groupBy('DATE(created_at)')
            ->orderBy('tanggal', 'ASC')
            ->get()
            ->getResultArray();

        $recentOrders = $orderModel
            ->select('orders.*, users.name AS customer_name, payments.payment_status')
            ->join('users', 'users.id_user = orders.id_user')
            ->join('payments', 'payments.id_order = orders.id_order', 'left')
            ->orderBy('orders.id_order', 'DESC')
            ->findAll(6);

        $lowStockProducts = $productModel
            ->where('stock <=', 5)
            ->orderBy('stock', 'ASC')
            ->findAll(5);

        return view('admin/dashboard', [
            'title'                => 'Dashboard Admin — ShopEase',
            'activeMenu'           => 'admin',
            'totalProducts'        => $productModel->countAll(),
            'totalCustomers'       => $userModel->where('role', 'customer')->countAllResults(),
            'totalOrders'          => $orderModel->countAll(),
            'totalSales'           => (float) ($salesRow['total_sales'] ?? 0),
            'pendingOrders'        => $orderModel->where('order_status', 'pending_payment')->countAllResults(),
            'waitingVerifications' => $paymentModel->where('payment_status', 'submitted')->countAllResults(),
            'dailySales'           => $dailySales,
            'recentOrders'         => $recentOrders,
            'lowStockProducts'     => $lowStockProducts,
        ]);
    }
}