<?php

namespace App\Models;

use CodeIgniter\Model;

class CourtModel extends Model
{
    protected $table            = 'courts';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'name',
        'floor_type',
        'price_per_hour',
        'description',
        'image',
        'status',
    ];
}