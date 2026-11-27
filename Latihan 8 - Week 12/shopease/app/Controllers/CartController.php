<?php

namespace App\Controllers;

use App\Models\CartItemModel;
use App\Models\CartModel;
use App\Models\ProductModel;

class CartController extends BaseController
{
    protected $cartModel;
    protected $cartItemModel;
    protected $productModel;

    public function __construct()
    {
        $this->cartModel     = new CartModel();
        $this->cartItemModel = new CartItemModel();
        $this->productModel  = new ProductModel();
    }

    public function index()
    {
        $cart  = $this->cartModel->getOrCreateByUser((int) session()->get('user_id'));
        $items = $this->cartItemModel->getItemsWithProducts((int) $cart['id_cart']);

        $subtotal = 0;
        foreach ($items as &$item) {
            $item['line_subtotal'] = (float) $item['price'] * (int) $item['quantity'];
            $subtotal += $item['line_subtotal'];
        }

        return view('frontend/cart', [
            'title'      => 'Keranjang Belanja — ShopEase',
            'activeMenu' => 'cart',
            'items'      => $items,
            'subtotal'   => $subtotal,
        ]);
    }

    public function add()
    {
        $productId = (int) $this->request->getPost('id_product');
        $quantity  = (int) $this->request->getPost('quantity');

        if ($quantity < 1) {
            return redirect()->back()->with('error', 'Jumlah pembelian minimal 1.');
        }

        $product = $this->productModel
            ->where('status', 'tersedia')
            ->find($productId);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak tersedia.');
        }

        $cart     = $this->cartModel->getOrCreateByUser((int) session()->get('user_id'));
        $existing = $this->cartItemModel
            ->where('id_cart', $cart['id_cart'])
            ->where('id_product', $productId)
            ->first();

        $newQty = $existing ? ((int) $existing['quantity'] + $quantity) : $quantity;

        if ($newQty > (int) $product['stock']) {
            return redirect()->back()
                ->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product['stock'] . ' unit.');
        }

        if ($existing) {
            $this->cartItemModel->update($existing['id_cart_item'], ['quantity' => $newQty]);
        } else {
            $this->cartItemModel->insert([
                'id_cart'    => $cart['id_cart'],
                'id_product' => $productId,
                'quantity'   => $quantity,
            ]);
        }

        return redirect()->to('/cart')
            ->with('success', $product['name'] . ' ditambahkan ke keranjang.');
    }

    public function update($itemId)
    {
        $quantity = (int) $this->request->getPost('quantity');
        $cart     = $this->cartModel->getOrCreateByUser((int) session()->get('user_id'));

        $item = $this->cartItemModel
            ->where('id_cart_item', (int) $itemId)
            ->where('id_cart', $cart['id_cart'])
            ->first();

        if (!$item) {
            return redirect()->to('/cart')->with('error', 'Item keranjang tidak ditemukan.');
        }

        if ($quantity < 1) {
            $this->cartItemModel->delete($item['id_cart_item']);
            return redirect()->to('/cart')->with('success', 'Item dihapus dari keranjang.');
        }

        $product = $this->productModel->find($item['id_product']);
        if (!$product || $product['status'] !== 'tersedia' || $quantity > (int) $product['stock']) {
            return redirect()->to('/cart')
                ->with('error', 'Jumlah melebihi stok tersedia (' . ($product['stock'] ?? 0) . ' unit).');
        }

        $this->cartItemModel->update($item['id_cart_item'], ['quantity' => $quantity]);

        return redirect()->to('/cart')->with('success', 'Jumlah item diperbarui.');
    }

    public function remove($itemId)
    {
        $cart = $this->cartModel->getOrCreateByUser((int) session()->get('user_id'));

        $item = $this->cartItemModel
            ->where('id_cart_item', (int) $itemId)
            ->where('id_cart', $cart['id_cart'])
            ->first();

        if ($item) {
            $this->cartItemModel->delete($item['id_cart_item']);
        }

        return redirect()->to('/cart')->with('success', 'Item dihapus dari keranjang.');
    }
}