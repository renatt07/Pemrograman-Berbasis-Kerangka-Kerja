<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdiModel;

class ProdiController extends BaseController
{
    protected $prodiModel;

    public function __construct()
    {
        $this->prodiModel = new ProdiModel();
    }

    public function index()
    {
        return view('admin/prodi', [
            'title'     => 'Program Studi',
            'prodiList' => $this->prodiModel->orderBy('kode_prodi', 'ASC')->findAll(),
            'edit'      => null,
        ]);
    }

    public function edit(int $id)
    {
        $edit = $this->prodiModel->find($id);
        if (! $edit) {
            return redirect()->to('/admin/prodi')->with('error', 'Program studi tidak ditemukan.');
        }

        return view('admin/prodi', [
            'title'     => 'Edit Program Studi',
            'prodiList' => $this->prodiModel->orderBy('kode_prodi', 'ASC')->findAll(),
            'edit'      => $edit,
        ]);
    }

    public function store()
    {
        $rules = [
            'kode_prodi' => 'required|max_length[20]|is_unique[program_studi.kode_prodi]',
            'nama_prodi' => 'required|max_length[100]',
            'fakultas'   => 'required|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->prodiModel->save([
            'kode_prodi' => strtoupper(trim($this->request->getPost('kode_prodi'))),
            'nama_prodi' => trim($this->request->getPost('nama_prodi')),
            'fakultas'   => trim($this->request->getPost('fakultas')),
        ]);

        return redirect()->to('/admin/prodi')->with('success', 'Program studi berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        $prodi = $this->prodiModel->find($id);
        if (! $prodi) {
            return redirect()->to('/admin/prodi')->with('error', 'Program studi tidak ditemukan.');
        }

        $rules = [
            'kode_prodi' => "required|max_length[20]|is_unique[program_studi.kode_prodi,id,{$id}]",
            'nama_prodi' => 'required|max_length[100]',
            'fakultas'   => 'required|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->prodiModel->update($id, [
            'kode_prodi' => strtoupper(trim($this->request->getPost('kode_prodi'))),
            'nama_prodi' => trim($this->request->getPost('nama_prodi')),
            'fakultas'   => trim($this->request->getPost('fakultas')),
        ]);

        return redirect()->to('/admin/prodi')->with('success', 'Program studi berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $this->prodiModel->delete($id);
        return redirect()->to('/admin/prodi')->with('success', 'Program studi berhasil dihapus.');
    }
}