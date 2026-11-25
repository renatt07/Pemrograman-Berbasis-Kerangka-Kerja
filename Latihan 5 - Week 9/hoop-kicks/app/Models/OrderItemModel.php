<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table         = 'order_items';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'order_id',
        'product_id',
        'product_name',
        'shoe_size',
        'price',
        'quantity',
        'subtotal',
    ];

    public function getByOrder(int $orderId)
    {
        return $this->select('order_items.*, products.sku, products.image, products.brand')
            ->join('products', 'products.id = order_items.product_id', 'left')
            ->where('order_items.order_id', $orderId)
            ->findAll();
    }
}