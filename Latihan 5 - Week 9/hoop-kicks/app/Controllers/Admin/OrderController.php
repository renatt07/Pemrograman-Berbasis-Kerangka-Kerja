<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\ProductModel;

class OrderController extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $productModel;

    public function __construct()
    {
        $this->orderModel     = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->productModel   = new ProductModel();
    }

    public function index()
    {
        $orders = $this->orderModel->getAllWithCustomer();
        foreach ($orders as &$order) {
            $order['items'] = $this->orderItemModel->getByOrder((int) $order['id']);
        }
        unset($order);

        return view('admin/orders/index', [
            'title'  => 'Kelola Pesanan',
            'orders' => $orders,
        ]);
    }

    public function updateStatus(int $id)
    {
        $order = $this->orderModel->find($id);
        if (! $order) {
            return redirect()->to('/admin/orders')->with('error', 'Pesanan tidak ditemukan.');
        }

        $newStatus = (string) $this->request->getPost('status');
        if (! in_array($newStatus, ['pending', 'paid', 'shipped', 'completed', 'cancelled'], true)) {
            return redirect()->to('/admin/orders')->with('error', 'Status pesanan tidak valid.');
        }

        if ($order['status'] === 'cancelled' && $newStatus !== 'cancelled') {
            return redirect()->to('/admin/orders')->with('error', 'Pesanan yang sudah dibatalkan tidak dapat diaktifkan kembali.');
        }

        // Jika berubah menjadi cancelled, kembalikan stok produk otomatis
        if ($order['status'] !== 'cancelled' && $newStatus === 'cancelled') {
            $items = $this->orderItemModel->where('order_id', $id)->findAll();
            foreach ($items as $item) {
                if (! empty($item['product_id'])) {
                    $product = $this->productModel->find($item['product_id']);
                    if ($product) {
                        $this->productModel->update($product['id'], [
                            'stock' => (int) $product['stock'] + (int) $item['quantity'],
                        ]);
                    }
                }
            }
        }

        $this->orderModel->update($id, ['status' => $newStatus]);

        return redirect()->to('/admin/orders')->with('success', 'Status pesanan ' . $order['order_code'] . ' diubah menjadi ' . strtoupper($newStatus) . '.');
    }
}