<?php

namespace App\Models;

use CodeIgniter\Model;

class MataKuliahModel extends Model
{
    protected $table         = 'mata_kuliah';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['prodi_id', 'kode_mk', 'nama_mk', 'sks', 'semester'];

    public function getAllWithProdi()
    {
        return $this->select('mata_kuliah.*, program_studi.nama_prodi, program_studi.kode_prodi')
            ->join('program_studi', 'program_studi.id = mata_kuliah.prodi_id')
            ->orderBy('mata_kuliah.semester', 'ASC')
            ->orderBy('mata_kuliah.kode_mk', 'ASC')
            ->findAll();
    }
}