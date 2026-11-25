<?php

namespace App\Controllers\Dosen;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\FrsDetailModel;
use App\Models\KelasModel;

class KelasController extends BaseController
{
    protected $dosenModel;
    protected $kelasModel;
    protected $frsModel;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
        $this->kelasModel = new KelasModel();
        $this->frsModel   = new FrsDetailModel();
    }

    public function index()
    {
        $dosen = $this->dosenModel->getByUserId((int) session()->get('user_id'));

        return view('dosen/kelas', [
            'title'     => 'Kelas Diampu',
            'kelasList' => $this->kelasModel->getByDosen((int) $dosen['id']),
        ]);
    }

    public function detail(int $kelasId)
    {
        $dosen = $this->dosenModel->getByUserId((int) session()->get('user_id'));
        $kelas = $this->kelasModel->getDetail($kelasId);

        if (! $kelas || (int) $kelas['dosen_id'] !== (int) $dosen['id']) {
            return redirect()->to('/dosen/kelas')->with('error', 'Kelas tidak ditemukan atau bukan kelas ampu Anda.');
        }

        return view('dosen/nilai', [
            'title'   => 'Input Nilai — ' . $kelas['kode_mk'],
            'kelas'   => $kelas,
            'peserta' => $this->frsModel->getByKelas($kelasId),
        ]);
    }

    public function simpanNilai(int $kelasId)
    {
        $dosen = $this->dosenModel->getByUserId((int) session()->get('user_id'));
        $kelas = $this->kelasModel->getDetail($kelasId);

        if (! $kelas || (int) $kelas['dosen_id'] !== (int) $dosen['id']) {
            return redirect()->to('/dosen/kelas')->with('error', 'Akses kelas ditolak.');
        }

        $nilaiInput = $this->request->getPost('nilai') ?? [];

        foreach ($nilaiInput as $frsId => $nilaiAngka) {
            $frs = $this->frsModel->where('id', (int) $frsId)
                ->where('kelas_id', $kelasId)
                ->first();

            if (! $frs) {
                continue;
            }

            if ($nilaiAngka === '' || $nilaiAngka === null) {
                $this->frsModel->update((int) $frsId, [
                    'nilai_angka' => null,
                    'nilai_huruf' => null,
                    'bobot'       => null,
                ]);
                continue;
            }

            $angka = (float) $nilaiAngka;
            if ($angka < 0 || $angka > 100) {
                return redirect()->back()->with('error', 'Nilai angka harus berada di antara 0 sampai 100.');
            }

            $konversi = FrsDetailModel::konversiNilai($angka);
            $this->frsModel->update((int) $frsId, [
                'nilai_angka' => $angka,
                'nilai_huruf' => $konversi['huruf'],
                'bobot'       => $konversi['bobot'],
            ]);
        }

        return redirect()->to('/dosen/kelas/' . $kelasId)->with('success', 'Nilai mahasiswa berhasil disimpan.');
    }
}