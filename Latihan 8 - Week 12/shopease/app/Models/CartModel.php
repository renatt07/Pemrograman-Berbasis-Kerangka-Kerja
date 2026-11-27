<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table            = 'carts';
    protected $primaryKey       = 'id_cart';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_user'];
    protected $useTimestamps    = true;

    public function getOrCreateByUser(int $userId): array
    {
        $cart = $this->where('id_user', $userId)->first();
        if (!$cart) {
            $id   = $this->insert(['id_user' => $userId]);
            $cart = $this->find($id);
        }

        return $cart;
    }

    public static function countUserItems(int $userId): int
    {
        if ($userId <= 0) {
            return 0;
        }

        $db  = \Config\Database::connect();
        $row = $db->table('cart_items')
            ->selectSum('cart_items.quantity', 'total_qty')
            ->join('carts', 'carts.id_cart = cart_items.id_cart')
            ->where('carts.id_user', $userId)
            ->get()
            ->getRowArray();

        return (int) ($row['total_qty'] ?? 0);
    }
}