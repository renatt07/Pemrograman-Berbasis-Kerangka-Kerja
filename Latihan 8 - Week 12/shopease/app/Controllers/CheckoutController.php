<?php

namespace App\Controllers;

use App\Models\CartItemModel;
use App\Models\CartModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Models\ProductModel;
use App\Models\ShipmentModel;
use App\Models\UserModel;

class CheckoutController extends BaseController
{
    private const SHIPPING_RATES = [
        'reguler' => ['label' => 'Reguler (2–4 hari)', 'cost' => 25000],
        'express' => ['label' => 'Express (1–2 hari)', 'cost' => 50000],
    ];

    public function index()
    {
        $userId        = (int) session()->get('user_id');
        $cartModel     = new CartModel();
        $cartItemModel = new CartItemModel();
        $userModel     = new UserModel();

        $cart  = $cartModel->getOrCreateByUser($userId);
        $items = $cartItemModel->getItemsWithProducts((int) $cart['id_cart']);

        if (empty($items)) {
            return redirect()->to('/cart')
                ->with('error', 'Keranjang belanja masih kosong.');
        }

        $subtotal = 0;
        foreach ($items as &$item) {
            $item['line_subtotal'] = (float) $item['price'] * (int) $item['quantity'];
            $subtotal += $item['line_subtotal'];
        }

        return view('frontend/checkout', [
            'title'         => 'Checkout — ShopEase',
            'activeMenu'    => 'cart',
            'user'          => $userModel->find($userId),
            'items'         => $items,
            'subtotal'      => $subtotal,
            'shippingRates' => self::SHIPPING_RATES,
        ]);
    }

    public function process()
    {
        $rules = [
            'recipient_name'   => 'required|min_length[3]|max_length[100]',
            'phone'            => 'required|min_length[8]|max_length[25]',
            'shipping_address' => 'required|min_length[10]',
            'shipping_service' => 'required|in_list[reguler,express]',
            'payment_method'   => 'required|in_list[Transfer Bank BCA,Transfer Bank Mandiri,QRIS / E-Wallet]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userId          = (int) session()->get('user_id');
        $shippingService = (string) $this->request->getPost('shipping_service');
        $shippingCost    = self::SHIPPING_RATES[$shippingService]['cost'];
        $paymentMethod   = (string) $this->request->getPost('payment_method');

        $cartModel      = new CartModel();
        $cartItemModel  = new CartItemModel();
        $productModel   = new ProductModel();
        $orderModel     = new OrderModel();
        $orderItemModel = new OrderItemModel();
        $paymentModel   = new PaymentModel();
        $shipmentModel  = new ShipmentModel();

        $cart = $cartModel->where('id_user', $userId)->first();
        if (!$cart) {
            return redirect()->to('/cart')->with('error', 'Keranjang tidak ditemukan.');
        }

        $cartItems = $cartItemModel->where('id_cart', $cart['id_cart'])->findAll();
        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Keranjang belanja masih kosong.');
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $preparedItems = [];
            $subtotal      = 0;

            // Ambil ulang harga & stok terbaru langsung dari database
            foreach ($cartItems as $ci) {
                $product = $productModel->find($ci['id_product']);
                $qty     = (int) $ci['quantity'];

                if (!$product || $product['status'] !== 'tersedia') {
                    throw new \RuntimeException('Produk "' . ($product['name'] ?? 'terpilih') . '" sedang tidak tersedia.');
                }
                if ($qty < 1 || (int) $product['stock'] < $qty) {
                    throw new \RuntimeException('Stok "' . $product['name'] . '" tidak mencukupi (tersisa ' . $product['stock'] . ').');
                }

                $lineSubtotal = (float) $product['price'] * $qty;
                $subtotal    += $lineSubtotal;

                $preparedItems[] = [
                    'product'      => $product,
                    'quantity'     => $qty,
                    'lineSubtotal' => $lineSubtotal,
                ];
            }

            $total       = $subtotal + $shippingCost;
            $orderNumber = 'SE-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));

            // 1. Simpan header pesanan
            $orderId = $orderModel->insert([
                'id_user'          => $userId,
                'order_number'     => $orderNumber,
                'recipient_name'   => trim((string) $this->request->getPost('recipient_name')),
                'phone'            => trim((string) $this->request->getPost('phone')),
                'shipping_address' => trim((string) $this->request->getPost('shipping_address')),
                'notes'            => trim((string) $this->request->getPost('notes')) ?: null,
                'subtotal'         => $subtotal,
                'shipping_cost'    => $shippingCost,
                'total'            => $total,
                'order_status'     => 'pending_payment',
            ]);

            // 2. Simpan rincian item (snapshot nama & harga) + kurangi stok
            foreach ($preparedItems as $row) {
                $p = $row['product'];

                $orderItemModel->insert([
                    'id_order'     => $orderId,
                    'id_product'   => $p['id_product'],
                    'product_name' => $p['name'],
                    'price'        => $p['price'],
                    'quantity'     => $row['quantity'],
                    'subtotal'     => $row['lineSubtotal'],
                ]);

                $productModel->update($p['id_product'], [
                    'stock' => (int) $p['stock'] - $row['quantity'],
                ]);
            }

            // 3. Buat record awal pembayaran & pengiriman
            $paymentModel->insert([
                'id_order'       => $orderId,
                'method'         => $paymentMethod,
                'amount'         => $total,
                'payment_status' => 'unpaid',
            ]);

            $shipmentModel->insert([
                'id_order'        => $orderId,
                'shipment_status' => 'pending',
            ]);

            // 4. Kosongkan keranjang
            $cartItemModel->where('id_cart', $cart['id_cart'])->delete();

            if ($db->transStatus() === false) {
                throw new \RuntimeException('Transaksi database gagal disimpan.');
            }

            $db->transCommit();
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->to('/cart')->with('error', $e->getMessage());
        }

        return redirect()->to('/orders/' . $orderId)
            ->with('success', 'Pesanan ' . $orderNumber . ' berhasil dibuat! Silakan unggah bukti pembayaran Anda.');
    }
}