<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table            = 'payments';
    protected $primaryKey       = 'id_payment';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_order', 'method', 'amount', 'proof_file',
        'payment_status', 'verified_by', 'verified_at',
    ];
    protected $useTimestamps = true;
}