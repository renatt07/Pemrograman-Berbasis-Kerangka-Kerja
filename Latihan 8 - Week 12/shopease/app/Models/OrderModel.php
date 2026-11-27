<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id_order';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_user', 'order_number', 'recipient_name', 'phone',
        'shipping_address', 'notes', 'subtotal', 'shipping_cost',
        'total', 'order_status',
    ];
    protected $useTimestamps = true;
}