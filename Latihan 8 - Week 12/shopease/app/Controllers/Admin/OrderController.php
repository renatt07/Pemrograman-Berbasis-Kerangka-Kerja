<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Models\ProductModel;
use App\Models\ShipmentModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class OrderController extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $paymentModel;
    protected $shipmentModel;
    protected $productModel;

    public function __construct()
    {
        $this->orderModel     = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->paymentModel   = new PaymentModel();
        $this->shipmentModel  = new ShipmentModel();
        $this->productModel   = new ProductModel();
    }

    public function index()
    {
        $statusFilter = trim((string) $this->request->getGet('status'));

        $this->orderModel
            ->select('orders.*, users.name AS customer_name, users.email AS customer_email, payments.payment_status, payments.proof_file, shipments.courier, shipments.tracking_number, shipments.shipment_status')
            ->join('users', 'users.id_user = orders.id_user')
            ->join('payments', 'payments.id_order = orders.id_order', 'left')
            ->join('shipments', 'shipments.id_order = orders.id_order', 'left');

        if ($statusFilter !== '') {
            $this->orderModel->where('orders.order_status', $statusFilter);
        }

        $orders = $this->orderModel->orderBy('orders.id_order', 'DESC')->findAll();

        return view('admin/orders/index', [
            'title'        => 'Manajemen Pesanan — ShopEase',
            'activeMenu'   => 'admin_orders',
            'orders'       => $orders,
            'statusFilter' => $statusFilter,
        ]);
    }

    public function detail($orderId)
    {
        $order = $this->orderModel
            ->select('orders.*, users.name AS customer_name, users.email AS customer_email')
            ->join('users', 'users.id_user = orders.id_user')
            ->find((int) $orderId);

        if (!$order) {
            throw PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan.');
        }

        return view('admin/orders/detail', [
            'title'      => 'Detail Pesanan ' . $order['order_number'],
            'activeMenu' => 'admin_orders',
            'order'      => $order,
            'items'      => $this->orderItemModel->where('id_order', $order['id_order'])->findAll(),
            'payment'    => $this->paymentModel->where('id_order', $order['id_order'])->first(),
            'shipment'   => $this->shipmentModel->where('id_order', $order['id_order'])->first(),
        ]);
    }

    public function verifyPayment($orderId)
    {
        $order   = $this->orderModel->find((int) $orderId);
        $payment = $this->paymentModel->where('id_order', (int) $orderId)->first();
        $action  = (string) $this->request->getPost('action');

        if (!$order || !$payment) {
            return redirect()->back()->with('error', 'Data pesanan atau pembayaran tidak ditemukan.');
        }

        if ($order['order_status'] === 'cancelled') {
            return redirect()->back()->with('error', 'Pesanan sudah dibatalkan.');
        }

        if ($action === 'approve') {
            $this->paymentModel->update($payment['id_payment'], [
                'payment_status' => 'verified',
                'verified_by'    => (int) session()->get('user_id'),
                'verified_at'    => date('Y-m-d H:i:s'),
            ]);
            $this->orderModel->update($order['id_order'], [
                'order_status' => 'processing',
            ]);

            return redirect()->back()->with('success', 'Pembayaran disetujui. Pesanan siap diproses oleh Operator.');
        }

        if ($action === 'reject') {
            $this->paymentModel->update($payment['id_payment'], [
                'payment_status' => 'rejected',
                'verified_by'    => (int) session()->get('user_id'),
                'verified_at'    => date('Y-m-d H:i:s'),
            ]);
            $this->orderModel->update($order['id_order'], [
                'order_status' => 'pending_payment',
            ]);

            return redirect()->back()->with('success', 'Bukti pembayaran ditolak. Customer diminta mengunggah ulang.');
        }

        return redirect()->back()->with('error', 'Aksi verifikasi tidak valid.');
    }

    public function updateShipment($orderId)
    {
        $order    = $this->orderModel->find((int) $orderId);
        $shipment = $this->shipmentModel->where('id_order', (int) $orderId)->first();

        if (!$order || !$shipment) {
            return redirect()->back()->with('error', 'Data pengiriman tidak ditemukan.');
        }

        if (!in_array($order['order_status'], ['processing', 'shipped'], true)) {
            return redirect()->back()->with('error', 'Pengiriman hanya bisa diperbarui setelah pembayaran diverifikasi.');
        }

        $rules = [
            'courier'         => 'required|min_length[2]|max_length[100]',
            'tracking_number' => 'required|min_length[5]|max_length[100]',
            'shipment_status' => 'required|in_list[pending,shipped,delivered]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', implode(' ', $this->validator->getErrors()));
        }

        $status = (string) $this->request->getPost('shipment_status');
        $now    = date('Y-m-d H:i:s');

        $updateData = [
            'courier'         => trim((string) $this->request->getPost('courier')),
            'tracking_number' => trim((string) $this->request->getPost('tracking_number')),
            'shipment_status' => $status,
        ];

        if ($status === 'shipped') {
            $updateData['shipped_at'] = $shipment['shipped_at'] ?: $now;
            $this->orderModel->update($order['id_order'], ['order_status' => 'shipped']);
        } elseif ($status === 'delivered') {
            $updateData['shipped_at']   = $shipment['shipped_at'] ?: $now;
            $updateData['delivered_at'] = $now;
            $this->orderModel->update($order['id_order'], ['order_status' => 'completed']);
        }

        $this->shipmentModel->update($shipment['id_shipment'], $updateData);

        return redirect()->back()->with('success', 'Informasi pengiriman & nomor resi berhasil diperbarui.');
    }

    public function cancel($orderId)
    {
        $order = $this->orderModel->find((int) $orderId);
        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        if (in_array($order['order_status'], ['shipped', 'completed', 'cancelled'], true)) {
            return redirect()->back()->with('error', 'Pesanan pada status ini tidak dapat dibatalkan.');
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $items = $this->orderItemModel->where('id_order', $order['id_order'])->findAll();
            foreach ($items as $item) {
                if (!empty($item['id_product'])) {
                    $product = $this->productModel->find($item['id_product']);
                    if ($product) {
                        $this->productModel->update($product['id_product'], [
                            'stock' => (int) $product['stock'] + (int) $item['quantity'],
                        ]);
                    }
                }
            }

            $this->orderModel->update($order['id_order'], ['order_status' => 'cancelled']);
            $db->transCommit();
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Gagal membatalkan pesanan.');
        }

        return redirect()->back()->with('success', 'Pesanan dibatalkan dan stok produk telah dikembalikan.');
    }
}