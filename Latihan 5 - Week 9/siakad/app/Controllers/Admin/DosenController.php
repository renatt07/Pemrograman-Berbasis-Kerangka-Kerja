<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\ProdiModel;
use App\Models\UserModel;

class DosenController extends BaseController
{
    protected $dosenModel;
    protected $prodiModel;
    protected $userModel;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
        $this->prodiModel = new ProdiModel();$this->userModel  = new UserModel();
    }

    public function index()
    {
        return view('admin/dosen', [
            'title'     => 'Data Dosen',
            'dosenList' => $this->dosenModel->getAllWithProdi(),
            'prodiList' => $this->prodiModel->orderBy('nama_prodi', 'ASC')->findAll(),
            'edit'      => null,
        ]);
    }

    public function edit(int $id)
    {
        $edit =$this->dosenModel->select('dosen.*, users.email')
            ->join('users', 'users.id = dosen.user_id')
            ->find($id);

        if (! $edit) {
            return redirect()->to('/admin/dosen')->with('error', 'Data dosen tidak ditemukan.');
        }

        return view('admin/dosen', [
            'title'     => 'Edit Data Dosen',
            'dosenList' => $this->dosenModel->getAllWithProdi(),
            'prodiList' => $this->prodiModel->orderBy('nama_prodi', 'ASC')->findAll(),
            'edit'      => $edit,
        ]);
    }

    public function store()
    {
        $rules = [
            'nip'      => 'required|max_length[30]|is_unique[dosen.nip]',
            'nama'     => 'required|max_length[100]',
            'prodi_id' => 'required|integer',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nama = trim($this->request->getPost('nama'));

        $this->userModel->insert([
            'name'     => $nama,
            'email'    => trim($this->request->getPost('email')),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'dosen',
        ]);
        $userId =$this->userModel->getInsertID();

        $this->dosenModel->save([
            'user_id'  => $userId,
            'prodi_id' => $this->request->getPost('prodi_id'),
            'nip'      => trim($this->request->getPost('nip')),
            'nama'     => $nama,
        ]);

        return redirect()->to('/admin/dosen')->with('success', 'Data dosen dan akun login berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        $dosen = $this->dosenModel->find($id);
        if (! $dosen) {
            return redirect()->to('/admin/dosen')->with('error', 'Data dosen tidak ditemukan.');
        }

        $rules = [
            'nip'      => "required|max_length[30]|is_unique[dosen.nip,id,{$id}]",
            'nama'     => 'required|max_length[100]',
            'prodi_id' => 'required|integer',
            'email'    => "required|valid_email|is_unique[users.email,id,{$dosen['user_id']}]",
        ];

        $newPassword =$this->request->getPost('password');
        if (! empty($newPassword)) {$rules['password'] = 'min_length[6]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nama = trim($this->request->getPost('nama'));

        $this->dosenModel->update($id, [
            'prodi_id' => $this->request->getPost('prodi_id'),
            'nip'      => trim($this->request->getPost('nip')),
            'nama'     => $nama,
        ]);

        $userData = [
            'name'  => $nama,
            'email' => trim($this->request->getPost('email')),
        ];
        if (! empty($newPassword)) {
            $userData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }
        $this->userModel->update($dosen['user_id'],$userData);

        return redirect()->to('/admin/dosen')->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $dosen = $this->dosenModel->find($id);
        if ($dosen) {
            // Hapus akun user -> otomatis menghapus baris dosen (ON DELETE CASCADE)
            $this->userModel->delete($dosen['user_id']);
        }

        return redirect()->to('/admin/dosen')->with('success', 'Data dosen berhasil dihapus.');
    }
}