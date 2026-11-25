<?php

namespace App\Models;

use CodeIgniter\Model;

class FrsDetailModel extends Model
{
    protected $table         = 'frs_detail';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'mahasiswa_id',
        'kelas_id',
        'semester_ambil',
        'nilai_angka',
        'nilai_huruf',
        'bobot',
    ];

    public function getByKelas(int $kelasId)
    {
        return $this->select('frs_detail.*, mahasiswa.nrp, mahasiswa.nama as nama_mahasiswa, mahasiswa.angkatan')
            ->join('mahasiswa', 'mahasiswa.id = frs_detail.mahasiswa_id')
            ->where('frs_detail.kelas_id', $kelasId)
            ->orderBy('mahasiswa.nrp', 'ASC')
            ->findAll();
    }

    public function getByMahasiswa(int $mahasiswaId, ?int $semester = null)
    {
        $builder = $this->select('frs_detail.*, kelas.nama_kelas, kelas.tahun_ajaran, kelas.jadwal, kelas.ruangan, mata_kuliah.kode_mk, mata_kuliah.nama_mk, mata_kuliah.sks, dosen.nama as nama_dosen')
            ->join('kelas', 'kelas.id = frs_detail.kelas_id')
            ->join('mata_kuliah', 'mata_kuliah.id = kelas.mata_kuliah_id')
            ->join('dosen', 'dosen.id = kelas.dosen_id')
            ->where('frs_detail.mahasiswa_id', $mahasiswaId);

        if ($semester !== null) {
            $builder->where('frs_detail.semester_ambil', $semester);
        }

        return $builder->orderBy('frs_detail.semester_ambil', 'ASC')
            ->orderBy('mata_kuliah.kode_mk', 'ASC')
            ->findAll();
    }

    public function getTotalSksSemester(int $mahasiswaId, int $semester): int
    {
        $rows = $this->getByMahasiswa($mahasiswaId, $semester);
        return array_sum(array_column($rows, 'sks'));
    }

    public function hitungIpk(int $mahasiswaId): array
    {
        $rows = $this->getByMahasiswa($mahasiswaId);
        $totalSksLulus = 0;
        $totalMutu     = 0.0;

        foreach ($rows as $row) {
            if ($row['bobot'] !== null) {
                $totalSksLulus += (int) $row['sks'];
                $totalMutu     += ((int) $row['sks']) * ((float) $row['bobot']);
            }
        }

        return [
            'total_sks' => $totalSksLulus,
            'ipk'       => $totalSksLulus > 0 ? round($totalMutu / $totalSksLulus, 2) : 0.00,
        ];
    }

    public static function konversiNilai(float $nilai): array
    {
        return match (true) {
            $nilai >= 86 => ['huruf' => 'A',  'bobot' => 4.00],
            $nilai >= 76 => ['huruf' => 'AB', 'bobot' => 3.50],
            $nilai >= 66 => ['huruf' => 'B',  'bobot' => 3.00],
            $nilai >= 61 => ['huruf' => 'BC', 'bobot' => 2.50],
            $nilai >= 56 => ['huruf' => 'C',  'bobot' => 2.00],
            $nilai >= 41 => ['huruf' => 'D',  'bobot' => 1.00],
            default      => ['huruf' => 'E',  'bobot' => 0.00],
        };
    }
}