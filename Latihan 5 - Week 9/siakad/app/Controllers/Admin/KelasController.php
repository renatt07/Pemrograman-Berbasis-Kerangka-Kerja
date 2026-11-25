<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\KelasModel;
use App\Models\MataKuliahModel;

class KelasController extends BaseController
{
    protected $kelasModel;
    protected $mkModel;
    protected $dosenModel;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
        $this->mkModel    = new MataKuliahModel();
        $this->dosenModel = new DosenModel();
    }

    public function index()
    {
        return view('admin/kelas', [
            'title'     => 'Kelola Kelas',
            'kelasList' => $this->kelasModel->getAllWithDetails(),
            'mkList'    => $this->mkModel->orderBy('kode_mk', 'ASC')->findAll(),
            'dosenList' => $this->dosenModel->orderBy('nama', 'ASC')->findAll(),
            'edit'      => null,
        ]);
    }

    public function edit(int $id)
    {
        $edit = $this->kelasModel->find($id);
        if (! $edit) {
            return redirect()->to('/admin/kelas')->with('error', 'Data kelas tidak ditemukan.');
        }

        return view('admin/kelas', [
            'title'     => 'Edit Kelas',
            'kelasList' => $this->kelasModel->getAllWithDetails(),
            'mkList'    => $this->mkModel->orderBy('kode_mk', 'ASC')->findAll(),
            'dosenList' => $this->dosenModel->orderBy('nama', 'ASC')->findAll(),
            'edit'      => $edit,
        ]);
    }

    public function store()
    {
        $rules = [
            'mata_kuliah_id' => 'required|integer',
            'dosen_id'       => 'required|integer',
            'nama_kelas'     => 'required|max_length[20]',
            'tahun_ajaran'   => 'required|max_length[30]',
            'jadwal'         => 'required|max_length[80]',
            'ruangan'        => 'required|max_length[50]',
            'kuota'          => 'required|integer|greater_than_equal_to[5]|less_than_equal_to[200]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kelasModel->save([
            'mata_kuliah_id' => $this->request->getPost('mata_kuliah_id'),
            'dosen_id'       => $this->request->getPost('dosen_id'),
            'nama_kelas'     => strtoupper(trim($this->request->getPost('nama_kelas'))),
            'tahun_ajaran'   => trim($this->request->getPost('tahun_ajaran')),
            'jadwal'         => trim($this->request->getPost('jadwal')),
            'ruangan'        => trim($this->request->getPost('ruangan')),
            'kuota'          => $this->request->getPost('kuota'),
        ]);

        return redirect()->to('/admin/kelas')->with('success', 'Kelas baru berhasil dibuka.');
    }

    public function update(int $id)
    {
        $kelas = $this->kelasModel->find($id);
        if (! $kelas) {
            return redirect()->to('/admin/kelas')->with('error', 'Data kelas tidak ditemukan.');
        }

        $rules = [
            'mata_kuliah_id' => 'required|integer',
            'dosen_id'       => 'required|integer',
            'nama_kelas'     => 'required|max_length[20]',
            'tahun_ajaran'   => 'required|max_length[30]',
            'jadwal'         => 'required|max_length[80]',
            'ruangan'        => 'required|max_length[50]',
            'kuota'          => 'required|integer|greater_than_equal_to[5]|less_than_equal_to[200]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kelasModel->update($id, [
            'mata_kuliah_id' => $this->request->getPost('mata_kuliah_id'),
            'dosen_id'       => $this->request->getPost('dosen_id'),
            'nama_kelas'     => strtoupper(trim($this->request->getPost('nama_kelas'))),
            'tahun_ajaran'   => trim($this->request->getPost('tahun_ajaran')),
            'jadwal'         => trim($this->request->getPost('jadwal')),
            'ruangan'        => trim($this->request->getPost('ruangan')),
            'kuota'          => $this->request->getPost('kuota'),
        ]);

        return redirect()->to('/admin/kelas')->with('success', 'Data kelas (termasuk kuota) berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $this->kelasModel->delete($id);
        return redirect()->to('/admin/kelas')->with('success', 'Kelas berhasil dihapus.');
    }
}