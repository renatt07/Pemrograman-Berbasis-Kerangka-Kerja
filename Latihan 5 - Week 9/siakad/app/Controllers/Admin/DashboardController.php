<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\KelasModel;
use App\Models\MahasiswaModel;
use App\Models\MataKuliahModel;
use App\Models\ProdiModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $prodiModel = new ProdiModel();
        $dosenModel = new DosenModel();$mhsModel   = new MahasiswaModel();
        $mkModel    = new MataKuliahModel();$kelasModel = new KelasModel();

        return view('admin/dashboard', [
            'title'          => 'Dashboard Admin',
            'totalProdi'     => $prodiModel->countAll(),
            'totalDosen'     => $dosenModel->countAll(),
            'totalMahasiswa' => $mhsModel->countAll(),
            'totalMatkul'    => $mkModel->countAll(),
            'totalKelas'     => $kelasModel->countAll(),
            'kelasList'      => $kelasModel->getAllWithDetails(),
        ]);
    }
}