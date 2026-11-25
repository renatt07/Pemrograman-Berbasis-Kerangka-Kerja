<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $table         = 'program_studi';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['kode_prodi', 'nama_prodi', 'fakultas'];
}