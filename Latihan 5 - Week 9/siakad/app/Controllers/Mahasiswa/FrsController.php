<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;
use App\Models\FrsDetailModel;
use App\Models\KelasModel;
use App\Models\MahasiswaModel;

class FrsController extends BaseController
{
    protected $mhsModel;
    protected $kelasModel;
    protected $frsModel;

    public function __construct()
    {
        $this->mhsModel   = new MahasiswaModel();
        $this->kelasModel = new KelasModel();
        $this->frsModel   = new FrsDetailModel();
    }

    public function index()
    {
        $mhs      = $this->mhsModel->getByUserId((int) session()->get('user_id'));
        $semester = (int) $mhs['semester_aktif'];

        $frsAktif   = $this->frsModel->getByMahasiswa((int) $mhs['id'], $semester);
        $semuaFrs   = $this->frsModel->getByMahasiswa((int) $mhs['id']);
        $takenKelas = array_column($semuaFrs, 'kelas_id');

        return view('mahasiswa/frs', [
            'title'      => 'Pengisian FRS',
            'mhs'        => $mhs,
            'frsAktif'   => $frsAktif,
            'sksAktif'   => $this->frsModel->getTotalSksSemester((int) $mhs['id'], $semester),
            'kelasList'  => $this->kelasModel->getAllWithDetails(),
            'takenKelas' => $takenKelas,
        ]);
    }

    public function ambil()
    {
        $mhs     = $this->mhsModel->getByUserId((int) session()->get('user_id'));
        $kelasId = (int) $this->request->getPost('kelas_id');
        $kelas   = $this->kelasModel->getDetail($kelasId);

        if (! $kelas) {
            return redirect()->to('/mahasiswa/frs')->with('error', 'Kelas tidak ditemukan.');
        }

        // 1. Cek apakah kelas sudah pernah diambil
        $sudahAmbil = $this->frsModel->where('mahasiswa_id', $mhs['id'])
            ->where('kelas_id', $kelasId)
            ->first();
        if ($sudahAmbil) {
            return redirect()->to('/mahasiswa/frs')->with('error', 'Anda sudah mengambil kelas ini.');
        }

        // 2. Cek kuota kelas
        if ((int) $kelas['terisi'] >= (int) $kelas['kuota']) {
            return redirect()->to('/mahasiswa/frs')->with('error', 'Kuota kelas ' . $kelas['nama_mk'] . ' (' . $kelas['nama_kelas'] . ') sudah penuh.');
        }

        // 3. Cek batas SKS semester aktif
        $semester = (int) $mhs['semester_aktif'];
        $sksAktif = $this->frsModel->getTotalSksSemester((int) $mhs['id'], $semester);
        if (($sksAktif + (int) $kelas['sks']) > (int) $mhs['batas_sks']) {
            return redirect()->to('/mahasiswa/frs')->with('error', 'Gagal mengambil kelas: total SKS melebihi batas maksimal (' . $mhs['batas_sks'] . ' SKS).');
        }

        $this->frsModel->save([
            'mahasiswa_id'   => $mhs['id'],
            'kelas_id'       => $kelasId,
            'semester_ambil' => $semester,
        ]);

        return redirect()->to('/mahasiswa/frs')->with('success', 'Berhasil mengambil mata kuliah ' . $kelas['nama_mk'] . ' (Kelas ' . $kelas['nama_kelas'] . ').');
    }

    public function hapus(int $frsId)
    {
        $mhs = $this->mhsModel->getByUserId((int) session()->get('user_id'));
        $frs = $this->frsModel->find($frsId);

        if (! $frs || (int) $frs['mahasiswa_id'] !== (int) $mhs['id']) {
            return redirect()->to('/mahasiswa/frs')->with('error', 'Data FRS tidak ditemukan.');
        }

        if ($frs['nilai_angka'] !== null) {
            return redirect()->to('/mahasiswa/frs')->with('error', 'Mata kuliah yang sudah dinilai tidak dapat dibatalkan.');
        }

        $this->frsModel->delete($frsId);

        return redirect()->to('/mahasiswa/frs')->with('success', 'Mata kuliah berhasil dihapus dari FRS.');
    }

    public function cetakFrs()
    {
        $mhs      = $this->mhsModel->getByUserId((int) session()->get('user_id'));
        $semester = (int) $mhs['semester_aktif'];

        return view('mahasiswa/cetak_frs', [
            'mhs'      => $mhs,
            'frsAktif' => $this->frsModel->getByMahasiswa((int) $mhs['id'], $semester),
            'sksAktif' => $this->frsModel->getTotalSksSemester((int) $mhs['id'], $semester),
        ]);
    }
}