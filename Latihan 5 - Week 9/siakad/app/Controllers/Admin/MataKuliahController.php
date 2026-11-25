<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MataKuliahModel;
use App\Models\ProdiModel;

class MataKuliahController extends BaseController
{
    protected $mkModel;
    protected $prodiModel;

    public function __construct()
    {
        $this->mkModel    = new MataKuliahModel();
        $this->prodiModel = new ProdiModel();
    }

    public function index()
    {
        return view('admin/matakuliah', [
            'title'     => 'Mata Kuliah',
            'mkList'    => $this->mkModel->getAllWithProdi(),
            'prodiList' => $this->prodiModel->orderBy('nama_prodi', 'ASC')->findAll(),
            'edit'      => null,
        ]);
    }

    public function edit(int $id)
    {
        $edit = $this->mkModel->find($id);
        if (! $edit) {
            return redirect()->to('/admin/matakuliah')->with('error', 'Mata kuliah tidak ditemukan.');
        }

        return view('admin/matakuliah', [
            'title'     => 'Edit Mata Kuliah',
            'mkList'    => $this->mkModel->getAllWithProdi(),
            'prodiList' => $this->prodiModel->orderBy('nama_prodi', 'ASC')->findAll(),
            'edit'      => $edit,
        ]);
    }

    public function store()
    {
        $rules = [
            'prodi_id' => 'required|integer',
            'kode_mk'  => 'required|max_length[20]|is_unique[mata_kuliah.kode_mk]',
            'nama_mk'  => 'required|max_length[120]',
            'sks'      => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[6]',
            'semester' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[8]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->mkModel->save([
            'prodi_id' => $this->request->getPost('prodi_id'),
            'kode_mk'  => strtoupper(trim($this->request->getPost('kode_mk'))),
            'nama_mk'  => trim($this->request->getPost('nama_mk')),
            'sks'      => $this->request->getPost('sks'),
            'semester' => $this->request->getPost('semester'),
        ]);

        return redirect()->to('/admin/matakuliah')->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        $mk = $this->mkModel->find($id);
        if (! $mk) {
            return redirect()->to('/admin/matakuliah')->with('error', 'Mata kuliah tidak ditemukan.');
        }

        $rules = [
            'prodi_id' => 'required|integer',
            'kode_mk'  => "required|max_length[20]|is_unique[mata_kuliah.kode_mk,id,{$id}]",
            'nama_mk'  => 'required|max_length[120]',
            'sks'      => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[6]',
            'semester' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[8]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->mkModel->update($id, [
            'prodi_id' => $this->request->getPost('prodi_id'),
            'kode_mk'  => strtoupper(trim($this->request->getPost('kode_mk'))),
            'nama_mk'  => trim($this->request->getPost('nama_mk')),
            'sks'      => $this->request->getPost('sks'),
            'semester' => $this->request->getPost('semester'),
        ]);

        return redirect()->to('/admin/matakuliah')->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $this->mkModel->delete($id);
        return redirect()->to('/admin/matakuliah')->with('success', 'Mata kuliah berhasil dihapus.');
    }
}