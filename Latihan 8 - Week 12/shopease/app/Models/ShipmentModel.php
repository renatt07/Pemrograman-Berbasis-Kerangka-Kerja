<?php

namespace App\Models;

use CodeIgniter\Model;

class ShipmentModel extends Model
{
    protected $table            = 'shipments';
    protected $primaryKey       = 'id_shipment';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_order', 'courier', 'tracking_number',
        'shipment_status', 'shipped_at', 'delivered_at',
    ];
    protected $useTimestamps = true;
}