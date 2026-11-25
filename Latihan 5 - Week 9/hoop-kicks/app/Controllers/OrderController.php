<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\UserModel;

class OrderController extends BaseController
{
    protected $productModel;
    protected $orderModel;
    protected $orderItemModel;

    public function __construct()
    {
        $this->productModel   = new ProductModel();
        $this->orderModel     = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    public function checkout()
    {
        $cart = session()->get('cart') ?? [];
        if (empty($cart)) {
            return redirect()->to('/cart')->with('error', 'Keranjang belanja masih kosong.');
        }

        $items = [];
        $total = 0;
        foreach ($cart as $row) {
            $product = $this->productModel->find($row['product_id']);
            if (! $product) {
                continue;
            }
            $subtotal = (int) $product['price'] * (int) $row['quantity'];
            $total   += $subtotal;
            $items[]  = [
                'product_id' => $product['id'],
                'name'       => $product['name'],
                'brand'      => $product['brand'],
                'shoe_size'  => $row['shoe_size'],
                'price'      => (int) $product['price'],
                'quantity'   => (int) $row['quantity'],
                'subtotal'   => $subtotal,
            ];
        }

        $userModel = new UserModel();
        $user      = $userModel->find(session()->get('user_id'));

        return view('shop/checkout', [
            'title' => 'Checkout',
            'items' => $items,
            'total' => $total,
            'user'  => $user,
        ]);
    }

    public function placeOrder()
    {
        $cart = session()->get('cart') ?? [];
        if (empty($cart)) {
            return redirect()->to('/cart')->with('error', 'Keranjang belanja kosong.');
        }

        $rules = [
            'recipient_name'   => 'required|min_length[3]|max_length[100]',
            'phone'            => 'required|min_length[9]|max_length[25]',
            'shipping_address' => 'required|min_length[10]',
            'payment_method'   => 'required|in_list[Transfer Bank BCA,QRIS Instant,Virtual Account Mandiri,COD Surabaya]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Validasi stok agregat per produk sebelum transaksi
        $neededByProduct = [];
        $preparedItems   = [];
        $totalPrice      = 0;

        foreach ($cart as $row) {
            $pid = (int) $row['product_id'];
            $qty = (int) $row['quantity'];
            $neededByProduct[$pid] = ($neededByProduct[$pid] ?? 0) + $qty;
        }

        $productCache = [];
        foreach ($neededByProduct as $pid => $totalNeeded) {
            $product = $this->productModel->find($pid);
            if (! $product || (int) $product['stock'] < $totalNeeded) {
                $name = $product['name'] ?? 'Produk';
                return redirect()->to('/cart')->with('error', 'Stok ' . $name . ' tidak mencukupi. Silakan periksa keranjang Anda.');
            }
            $productCache[$pid] = $product;
        }

        foreach ($cart as $row) {
            $product   = $productCache[(int) $row['product_id']];
            $subtotal  = (int) $product['price'] * (int) $row['quantity'];
            $totalPrice += $subtotal;

            $preparedItems[] = [
                'product_id'   => $product['id'],
                'product_name' => $product['name'],
                'shoe_size'    => $row['shoe_size'],
                'price'        => (int) $product['price'],
                'quantity'     => (int) $row['quantity'],
                'subtotal'     => $subtotal,
            ];
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $orderCode = 'HK-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));

        $this->orderModel->insert([
            'order_code'       => $orderCode,
            'user_id'          => session()->get('user_id'),
            'recipient_name'   => trim($this->request->getPost('recipient_name')),
            'phone'            => trim($this->request->getPost('phone')),
            'shipping_address' => trim($this->request->getPost('shipping_address')),
            'payment_method'   => $this->request->getPost('payment_method'),
            'total_price'      => $totalPrice,
            'status'           => 'pending',
            'notes'            => trim((string) $this->request->getPost('notes')),
        ]);
        $orderId = $this->orderModel->getInsertID();

        foreach ($preparedItems as $item) {
            $item['order_id'] = $orderId;
            $this->orderItemModel->insert($item);
        }

        // Potong stok masing-masing produk
        foreach ($neededByProduct as $pid => $qtyUsed) {
            $newStock = (int) $productCache[$pid]['stock'] - $qtyUsed;
            $this->productModel->update($pid, ['stock' => $newStock]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to('/checkout')->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }

        session()->remove('cart');

        return redirect()->to('/my-orders')->with('success', 'Pesanan ' . $orderCode . ' berhasil dibuat! Stok produk telah diamankan.');
    }

    public function myOrders()
    {
        $orders = $this->orderModel->getByUser((int) session()->get('user_id'));

        foreach ($orders as &$order) {
            $order['items'] = $this->orderItemModel->getByOrder((int) $order['id']);
        }
        unset($order);

        return view('shop/orders', [
            'title'  => 'Riwayat Pesanan',
            'orders' => $orders,
        ]);
    }
}