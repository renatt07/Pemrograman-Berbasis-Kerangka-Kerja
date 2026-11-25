<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class CartController extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $cart  = session()->get('cart') ?? [];
        $items = [];
        $total = 0;

        foreach ($cart as $key => $row) {
            $product = $this->productModel->find($row['product_id']);
            if (! $product) {
                continue;
            }

            $qty      = min((int) $row['quantity'], max(1, (int) $product['stock']));
            $subtotal = (int) $product['price'] * $qty;
            $total   += $subtotal;

            $items[$key] = [
                'key'        => $key,
                'product_id' => $product['id'],
                'name'       => $product['name'],
                'slug'       => $product['slug'],
                'brand'      => $product['brand'],
                'sku'        => $product['sku'],
                'image'      => $product['image'],
                'shoe_size'  => $row['shoe_size'],
                'price'      => (int) $product['price'],
                'stock'      => (int) $product['stock'],
                'quantity'   => $qty,
                'subtotal'   => $subtotal,
            ];
        }

        return view('shop/cart', [
            'title' => 'Keranjang Belanja',
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function add()
    {
        $productId = (int) $this->request->getPost('product_id');
        $size      = trim((string) $this->request->getPost('shoe_size'));
        $qty       = max(1, (int) $this->request->getPost('quantity'));

        $product = $this->productModel->find($productId);
        if (! $product) {
            return redirect()->to('/')->with('error', 'Produk tidak ditemukan.');
        }

        if ((int) $product['stock'] < 1) {
            return redirect()->back()->with('error', 'Maaf, stok sepatu ini sedang habis.');
        }

        $allowedSizes = array_map('trim', explode(',', (string) $product['sizes']));
        if (empty($size) || ! in_array($size, $allowedSizes, true)) {
            return redirect()->back()->with('error', 'Silakan pilih ukuran yang tersedia terlebih dahulu.');
        }

        $cart = session()->get('cart') ?? [];
        $key  = $productId . '_' . $size;

        // Hitung total qty produk ini di seluruh ukuran dalam keranjang
        $currentProductQty = 0;
        foreach ($cart as $item) {
            if ((int) $item['product_id'] === $productId) {
                $currentProductQty += (int) $item['quantity'];
            }
        }

        if (($currentProductQty + $qty) > (int) $product['stock']) {
            return redirect()->back()->with('error', 'Jumlah melebihi stok tersedia (' . $product['stock'] . ' pasang).');
        }

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $qty;
        } else {
            $cart[$key] = [
                'product_id' => $productId,
                'shoe_size'  => $size,
                'quantity'   => $qty,
            ];
        }

        session()->set('cart', $cart);

        return redirect()->to('/cart')->with('success', $product['name'] . ' (Size ' . $size . ') ditambahkan ke keranjang.');
    }

    public function update()
    {
        $key = (string) $this->request->getPost('key');
        $qty = (int) $this->request->getPost('quantity');

        $cart = session()->get('cart') ?? [];
        if (! isset($cart[$key])) {
            return redirect()->to('/cart');
        }

        if ($qty <= 0) {
            unset($cart[$key]);
            session()->set('cart', $cart);
            return redirect()->to('/cart')->with('success', 'Item dihapus dari keranjang.');
        }

        $product = $this->productModel->find($cart[$key]['product_id']);
        if (! $product) {
            unset($cart[$key]);
            session()->set('cart', $cart);
            return redirect()->to('/cart');
        }

        $otherSizeQty = 0;
        foreach ($cart as $k => $item) {
            if ($k !== $key && (int) $item['product_id'] === (int) $product['id']) {
                $otherSizeQty += (int) $item['quantity'];
            }
        }

        if (($otherSizeQty + $qty) > (int) $product['stock']) {
            return redirect()->to('/cart')->with('error', 'Stok ' . $product['name'] . ' hanya tersisa ' . $product['stock'] . ' pasang.');
        }

        $cart[$key]['quantity'] = $qty;
        session()->set('cart', $cart);

        return redirect()->to('/cart')->with('success', 'Jumlah keranjang diperbarui.');
    }

    public function remove(string $key)
    {
        $cart = session()->get('cart') ?? [];
        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->set('cart', $cart);
        }

        return redirect()->to('/cart')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}