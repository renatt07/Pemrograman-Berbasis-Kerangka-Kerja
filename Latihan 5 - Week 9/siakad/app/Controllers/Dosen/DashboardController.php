<?php

namespace App\Controllers\Dosen;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\FrsDetailModel;
use App\Models\KelasModel;
use App\Models\MahasiswaModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $dosenModel = new DosenModel();
        $kelasModel = new KelasModel();
        $mhsModel   = new MahasiswaModel();

        $dosen = $dosenModel->getByUserId((int) session()->get('user_id'));
        if (! $dosen) {
            return redirect()->to('/logout')->with('error', 'Profil dosen tidak ditemukan.');
        }

        $kelasList     = $kelasModel->getByDosen((int) $dosen['id']);
        $perwalianList = $mhsModel->getByDosenWali((int) $dosen['id']);

        return view('dosen/dashboard', [
            'title'          => 'Dashboard Dosen',
            'dosen'          => $dosen,
            'kelasList'      => $kelasList,
            'totalKelas'     => count($kelasList),
            'totalPerwalian' => count($perwalianList),
        ]);
    }

    public function perwalian()
    {
        $dosenModel = new DosenModel();
        $mhsModel   = new MahasiswaModel();
        $frsModel   = new FrsDetailModel();

        $dosen = $dosenModel->getByUserId((int) session()->get('user_id'));
        if (! $dosen) {
            return redirect()->to('/logout')->with('error', 'Profil dosen tidak ditemukan.');
        }

        $mahasiswaList = $mhsModel->getByDosenWali((int) $dosen['id']);
        foreach ($mahasiswaList as &$m) {
            $ringkasan       = $frsModel->hitungIpk((int) $m['id']);
            $m['ipk']        = $ringkasan['ipk'];
            $m['total_sks']  = $ringkasan['total_sks'];
            $m['sks_aktif']  = $frsModel->getTotalSksSemester((int) $m['id'], (int) $m['semester_aktif']);
        }
        unset($m);

        return view('dosen/perwalian', [
            'title'         => 'Mahasiswa Perwalian',
            'dosen'         => $dosen,
            'mahasiswaList' => $mahasiswaList,
        ]);
    }
}