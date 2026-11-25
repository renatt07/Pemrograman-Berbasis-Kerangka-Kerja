<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table         = 'kelas';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'mata_kuliah_id',
        'dosen_id',
        'nama_kelas',
        'tahun_ajaran',
        'jadwal',
        'ruangan',
        'kuota',
    ];

    public function getAllWithDetails()
    {
        return $this->select('kelas.*, mata_kuliah.kode_mk, mata_kuliah.nama_mk, mata_kuliah.sks, mata_kuliah.semester, dosen.nama as nama_dosen, program_studi.nama_prodi, (SELECT COUNT(*) FROM frs_detail WHERE frs_detail.kelas_id = kelas.id) as terisi', false)
            ->join('mata_kuliah', 'mata_kuliah.id = kelas.mata_kuliah_id')
            ->join('program_studi', 'program_studi.id = mata_kuliah.prodi_id')
            ->join('dosen', 'dosen.id = kelas.dosen_id')
            ->orderBy('kelas.tahun_ajaran', 'DESC')
            ->orderBy('mata_kuliah.kode_mk', 'ASC')
            ->findAll();
    }

    public function getByDosen(int $dosenId)
    {
        return $this->select('kelas.*, mata_kuliah.kode_mk, mata_kuliah.nama_mk, mata_kuliah.sks, mata_kuliah.semester, (SELECT COUNT(*) FROM frs_detail WHERE frs_detail.kelas_id = kelas.id) as terisi', false)
            ->join('mata_kuliah', 'mata_kuliah.id = kelas.mata_kuliah_id')
            ->where('kelas.dosen_id', $dosenId)
            ->orderBy('kelas.tahun_ajaran', 'DESC')
            ->findAll();
    }

    public function getDetail(int $kelasId)
    {
        return $this->select('kelas.*, mata_kuliah.kode_mk, mata_kuliah.nama_mk, mata_kuliah.sks, mata_kuliah.semester, dosen.nama as nama_dosen, (SELECT COUNT(*) FROM frs_detail WHERE frs_detail.kelas_id = kelas.id) as terisi', false)
            ->join('mata_kuliah', 'mata_kuliah.id = kelas.mata_kuliah_id')
            ->join('dosen', 'dosen.id = kelas.dosen_id')
            ->where('kelas.id', $kelasId)
            ->first();
    }
}