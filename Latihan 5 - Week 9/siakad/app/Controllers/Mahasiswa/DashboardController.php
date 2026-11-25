<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;
use App\Models\FrsDetailModel;
use App\Models\MahasiswaModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $mhsModel = new MahasiswaModel();
        $frsModel = new FrsDetailModel();

        $mhs = $mhsModel->getByUserId((int) session()->get('user_id'));
        if (! $mhs) {
            return redirect()->to('/logout')->with('error', 'Profil mahasiswa tidak ditemukan.');
        }

        $ipkData  = $frsModel->hitungIpk((int) $mhs['id']);
        $frsAktif = $frsModel->getByMahasiswa((int) $mhs['id'], (int) $mhs['semester_aktif']);
        $sksAktif = $frsModel->getTotalSksSemester((int) $mhs['id'], (int) $mhs['semester_aktif']);

        return view('mahasiswa/dashboard', [
            'title'    => 'Dashboard Mahasiswa',
            'mhs'      => $mhs,
            'ipkData'  => $ipkData,
            'frsAktif' => $frsAktif,
            'sksAktif' => $sksAktif,
        ]);
    }
}