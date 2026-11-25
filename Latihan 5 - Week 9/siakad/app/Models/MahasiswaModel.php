<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table         = 'mahasiswa';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'user_id',
        'prodi_id',
        'dosen_wali_id',
        'nrp',
        'nama',
        'angkatan',
        'semester_aktif',
        'batas_sks',
    ];

    public function getAllWithRelations()
    {
        return $this->select('mahasiswa.*, program_studi.nama_prodi, users.email, dosen.nama as nama_dosen_wali')
            ->join('program_studi', 'program_studi.id = mahasiswa.prodi_id')
            ->join('users', 'users.id = mahasiswa.user_id')
            ->join('dosen', 'dosen.id = mahasiswa.dosen_wali_id', 'left')
            ->orderBy('mahasiswa.nrp', 'ASC')
            ->findAll();
    }

    public function getByUserId(int $userId)
    {
        return $this->select('mahasiswa.*, program_studi.kode_prodi, program_studi.nama_prodi, program_studi.fakultas, users.email, dosen.nama as nama_dosen_wali, dosen.nip as nip_dosen_wali')
            ->join('program_studi', 'program_studi.id = mahasiswa.prodi_id')
            ->join('users', 'users.id = mahasiswa.user_id')
            ->join('dosen', 'dosen.id = mahasiswa.dosen_wali_id', 'left')
            ->where('mahasiswa.user_id', $userId)
            ->first();
    }

    public function getByDosenWali(int $dosenId)
    {
        return $this->select('mahasiswa.*, program_studi.nama_prodi, users.email')
            ->join('program_studi', 'program_studi.id = mahasiswa.prodi_id')
            ->join('users', 'users.id = mahasiswa.user_id')
            ->where('mahasiswa.dosen_wali_id', $dosenId)
            ->orderBy('mahasiswa.nrp', 'ASC')
            ->findAll();
    }
}