<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    protected $table         = 'dosen';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['user_id', 'prodi_id', 'nip', 'nama'];

    public function getAllWithProdi()
    {
        return $this->select('dosen.*, program_studi.nama_prodi, users.email')
            ->join('program_studi', 'program_studi.id = dosen.prodi_id')
            ->join('users', 'users.id = dosen.user_id')
            ->orderBy('dosen.nama', 'ASC')
            ->findAll();
    }

    public function getByUserId(int $userId)
    {
        return $this->select('dosen.*, program_studi.nama_prodi, program_studi.fakultas, users.email')
            ->join('program_studi', 'program_studi.id = dosen.prodi_id')
            ->join('users', 'users.id = dosen.user_id')
            ->where('dosen.user_id', $userId)
            ->first();
    }
}