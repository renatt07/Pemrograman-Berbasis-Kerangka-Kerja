<?php

namespace App\Controllers;

use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Models\ShipmentModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class OrderController extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $paymentModel;
    protected $shipmentModel;

    public function __construct()
    {
        $this->orderModel     = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->paymentModel   = new PaymentModel();
        $this->shipmentModel  = new ShipmentModel();
    }

    public function index()
    {
        $userId = (int) session()->get('user_id');

        $orders = $this->orderModel
            ->select('orders.*, payments.payment_status, payments.method AS payment_method, shipments.courier, shipments.tracking_number, shipments.shipment_status')
            ->join('payments', 'payments.id_order = orders.id_order', 'left')
            ->join('shipments', 'shipments.id_order = orders.id_order', 'left')
            ->where('orders.id_user', $userId)
            ->orderBy('orders.id_order', 'DESC')
            ->findAll();

        return view('frontend/orders/index', [
            'title'      => 'Pesanan Saya — ShopEase',
            'activeMenu' => 'orders',
            'orders'     => $orders,
        ]);
    }

    public function detail($orderId)
    {
        $userId = (int) session()->get('user_id');
        $order  = $this->orderModel
            ->where('id_order', (int) $orderId)
            ->where('id_user', $userId)
            ->first();

        if (!$order) {
            throw PageNotFoundException::forPageNotFound('Pesanan tidak ditemukan.');
        }

        return view('frontend/orders/detail', [
            'title'      => 'Pesanan ' . $order['order_number'] . ' — ShopEase',
            'activeMenu' => 'orders',
            'order'      => $order,
            'items'      => $this->orderItemModel->where('id_order', $order['id_order'])->findAll(),
            'payment'    => $this->paymentModel->where('id_order', $order['id_order'])->first(),
            'shipment'   => $this->shipmentModel->where('id_order', $order['id_order'])->first(),
        ]);
    }

    public function uploadPayment($orderId)
    {
        $userId = (int) session()->get('user_id');
        $order  = $this->orderModel
            ->where('id_order', (int) $orderId)
            ->where('id_user', $userId)
            ->first();

        if (!$order) {
            return redirect()->to('/orders')->with('error', 'Pesanan tidak ditemukan.');
        }

        $payment = $this->paymentModel->where('id_order', $order['id_order'])->first();
        if (!$payment || !in_array($payment['payment_status'], ['unpaid', 'rejected'], true) || $order['order_status'] === 'cancelled') {
            return redirect()->back()->with('error', 'Bukti pembayaran tidak dapat diunggah pada status pesanan saat ini.');
        }

        $file = $this->request->getFile('proof');
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return redirect()->back()->with('error', 'Pilih file bukti pembayaran yang valid.');
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedMimes, true)) {
            return redirect()->back()->with('error', 'Format file harus JPG, PNG, atau WEBP.');
        }

        if ($file->getSizeByUnit('mb') > 2) {
            return redirect()->back()->with('error', 'Ukuran file maksimal 2 MB.');
        }

        $dir = FCPATH . 'uploads/payments/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Hapus bukti lama jika re-upload setelah ditolak
        if (!empty($payment['proof_file']) && is_file($dir . $payment['proof_file'])) {
            unlink($dir . $payment['proof_file']);
        }

        $filename = $file->getRandomName();
        $file->move($dir, $filename);

        $this->paymentModel->update($payment['id_payment'], [
            'proof_file'     => $filename,
            'payment_status' => 'submitted',
        ]);

        $this->orderModel->update($order['id_order'], [
            'order_status' => 'waiting_verification',
        ]);

        return redirect()->to('/orders/' . $order['id_order'])
            ->with('success', 'Bukti pembayaran berhasil diunggah dan menunggu verifikasi Admin.');
    }

    public function complete($orderId)
    {
        $userId = (int) session()->get('user_id');
        $order  = $this->orderModel
            ->where('id_order', (int) $orderId)
            ->where('id_user', $userId)
            ->first();

        if (!$order || $order['order_status'] !== 'shipped') {
            return redirect()->back()->with('error', 'Pesanan belum berstatus dikirim.');
        }

        $this->orderModel->update($order['id_order'], ['order_status' => 'completed']);

        $shipment = $this->shipmentModel->where('id_order', $order['id_order'])->first();
        if ($shipment) {
            $this->shipmentModel->update($shipment['id_shipment'], [
                'shipment_status' => 'delivered',
                'delivered_at'    => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->to('/orders/' . $order['id_order'])
            ->with('success', 'Terima kasih! Pesanan telah dikonfirmasi selesai.');
    }
}