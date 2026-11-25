<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table         = 'orders';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'order_code',
        'user_id',
        'recipient_name',
        'phone',
        'shipping_address',
        'payment_method',
        'total_price',
        'status',
        'notes',
    ];

    public function getAllWithCustomer()
    {
        return $this->select('orders.*, users.name as account_name, users.email as account_email')
            ->join('users', 'users.id = orders.user_id')
            ->orderBy('orders.created_at', 'DESC')
            ->findAll();
    }

    public function getByUser(int $userId)
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }
}