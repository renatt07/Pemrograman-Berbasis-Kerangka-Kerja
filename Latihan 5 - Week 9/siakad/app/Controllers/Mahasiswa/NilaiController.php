<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;
use App\Models\FrsDetailModel;
use App\Models\MahasiswaModel;

class NilaiController extends BaseController
{
    protected $mhsModel;
    protected $frsModel;

    public function __construct()
    {
        $this->mhsModel = new MahasiswaModel();
        $this->frsModel = new FrsDetailModel();
    }

    public function index()
    {
        $mhs        = $this->mhsModel->getByUserId((int) session()->get('user_id'));
        $semuaNilai = $this->frsModel->getByMahasiswa((int) $mhs['id']);
        $ipkData    = $this->frsModel->hitungIpk((int) $mhs['id']);

        // Kelompokkan nilai per semester & hitung IPS tiap semester
        $perSemester = [];
        foreach ($semuaNilai as $row) {
            $smt = (int) $row['semester_ambil'];
            if (! isset($perSemester[$smt])) {
                $perSemester[$smt] = ['items' => [], 'sks' => 0, 'mutu' => 0.0, 'ips' => 0.00];
            }
            $perSemester[$smt]['items'][] = $row;
            if ($row['bobot'] !== null) {
                $perSemester[$smt]['sks']  += (int) $row['sks'];
                $perSemester[$smt]['mutu'] += ((int) $row['sks']) * ((float) $row['bobot']);
            }
        }

        foreach ($perSemester as &$group) {
            $group['ips'] = $group['sks'] > 0 ? round($group['mutu'] / $group['sks'], 2) : 0.00;
        }
        unset($group);

        return view('mahasiswa/nilai', [
            'title'       => 'Nilai & IPK',
            'mhs'         => $mhs,
            'perSemester' => $perSemester,
            'ipkData'     => $ipkData,
        ]);
    }

    public function cetakTranskrip()
    {
        $mhs        = $this->mhsModel->getByUserId((int) session()->get('user_id'));
        $semuaNilai = $this->frsModel->getByMahasiswa((int) $mhs['id']);
        $ipkData    = $this->frsModel->hitungIpk((int) $mhs['id']);

        return view('mahasiswa/cetak_transkrip', [
            'mhs'        => $mhs,
            'semuaNilai' => $semuaNilai,
            'ipkData'    => $ipkData,
        ]);
    }
}