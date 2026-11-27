<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table            = 'order_items';
    protected $primaryKey       = 'id_order_item';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_order', 'id_product', 'product_name', 'price', 'quantity', 'subtotal',
    ];
    protected $useTimestamps = false;
}