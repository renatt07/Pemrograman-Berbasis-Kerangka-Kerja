<?php

namespace App\Models;

use CodeIgniter\Model;

class CartItemModel extends Model
{
    protected $table            = 'cart_items';
    protected $primaryKey       = 'id_cart_item';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_cart', 'id_product', 'quantity'];
    protected $useTimestamps    = true;

    public function getItemsWithProducts(int $cartId): array
    {
        $items = $this->select('cart_items.*, products.name, products.price, products.stock, products.status, categories.name AS category_name')
            ->join('products', 'products.id_product = cart_items.id_product')
            ->join('categories', 'categories.id_category = products.id_category')
            ->where('cart_items.id_cart', $cartId)
            ->orderBy('cart_items.id_cart_item', 'DESC')
            ->findAll();

        $productModel = new ProductModel();
        return $productModel->attachImages($items);
    }
}