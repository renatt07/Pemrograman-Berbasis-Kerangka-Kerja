<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Models\MahasiswaModel;
use App\Models\ProdiModel;
use App\Models\UserModel;

class MahasiswaController extends BaseController
{
    protected $mhsModel;
    protected $prodiModel;
    protected $dosenModel;
    protected $userModel;

    public function __construct()
    {
        $this->mhsModel   = new MahasiswaModel();
        $this->prodiModel = new ProdiModel();
        $this->dosenModel = new DosenModel();
        $this->userModel  = new UserModel();
    }

    public function index()
    {
        return view('admin/mahasiswa', [
            'title'     => 'Data Mahasiswa',
            'mhsList'   => $this->mhsModel->getAllWithRelations(),
            'prodiList' => $this->prodiModel->orderBy('nama_prodi', 'ASC')->findAll(),
            'dosenList' => $this->dosenModel->orderBy('nama', 'ASC')->findAll(),
            'edit'      => null,
        ]);
    }

    public function edit(int $id)
    {
        $edit = $this->mhsModel->select('mahasiswa.*, users.email')
            ->join('users', 'users.id = mahasiswa.user_id')
            ->find($id);

        if (! $edit) {
            return redirect()->to('/admin/mahasiswa')->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        return view('admin/mahasiswa', [
            'title'     => 'Edit Data Mahasiswa',
            'mhsList'   => $this->mhsModel->getAllWithRelations(),
            'prodiList' => $this->prodiModel->orderBy('nama_prodi', 'ASC')->findAll(),
            'dosenList' => $this->dosenModel->orderBy('nama', 'ASC')->findAll(),
            'edit'      => $edit,
        ]);
    }

    public function store()
    {
        $rules = [
            'nrp'            => 'required|max_length[30]|is_unique[mahasiswa.nrp]',
            'nama'           => 'required|max_length[100]',
            'prodi_id'       => 'required|integer',
            'angkatan'       => 'required|integer|greater_than_equal_to[2015]',
            'semester_aktif' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[14]',
            'batas_sks'      => 'required|integer|greater_than_equal_to[12]|less_than_equal_to[24]',
            'email'          => 'required|valid_email|is_unique[users.email]',
            'password'       => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nama = trim($this->request->getPost('nama'));

        $this->userModel->insert([
            'name'     => $nama,
            'email'    => trim($this->request->getPost('email')),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'mahasiswa',
        ]);
        $userId = $this->userModel->getInsertID();

        $this->mhsModel->save([
            'user_id'        => $userId,
            'prodi_id'       => $this->request->getPost('prodi_id'),
            'dosen_wali_id'  => $this->request->getPost('dosen_wali_id') ?: null,
            'nrp'            => trim($this->request->getPost('nrp')),
            'nama'           => $nama,
            'angkatan'       => $this->request->getPost('angkatan'),
            'semester_aktif' => $this->request->getPost('semester_aktif'),
            'batas_sks'      => $this->request->getPost('batas_sks'),
        ]);

        return redirect()->to('/admin/mahasiswa')->with('success', 'Data mahasiswa dan akun login berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        $mhs = $this->mhsModel->find($id);
        if (! $mhs) {
            return redirect()->to('/admin/mahasiswa')->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $rules = [
            'nrp'            => "required|max_length[30]|is_unique[mahasiswa.nrp,id,{$id}]",
            'nama'           => 'required|max_length[100]',
            'prodi_id'       => 'required|integer',
            'angkatan'       => 'required|integer|greater_than_equal_to[2015]',
            'semester_aktif' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[14]',
            'batas_sks'      => 'required|integer|greater_than_equal_to[12]|less_than_equal_to[24]',
            'email'          => "required|valid_email|is_unique[users.email,id,{$mhs['user_id']}]",
        ];

        $newPassword = $this->request->getPost('password');
        if (! empty($newPassword)) {
            $rules['password'] = 'min_length[6]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nama = trim($this->request->getPost('nama'));

        $this->mhsModel->update($id, [
            'prodi_id'       => $this->request->getPost('prodi_id'),
            'dosen_wali_id'  => $this->request->getPost('dosen_wali_id') ?: null,
            'nrp'            => trim($this->request->getPost('nrp')),
            'nama'           => $nama,
            'angkatan'       => $this->request->getPost('angkatan'),
            'semester_aktif' => $this->request->getPost('semester_aktif'),
            'batas_sks'      => $this->request->getPost('batas_sks'),
        ]);

        $userData = [
            'name'  => $nama,
            'email' => trim($this->request->getPost('email')),
        ];
        if (! empty($newPassword)) {
            $userData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }
        $this->userModel->update($mhs['user_id'], $userData);

        return redirect()->to('/admin/mahasiswa')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $mhs = $this->mhsModel->find($id);
        if ($mhs) {
            $this->userModel->delete($mhs['user_id']);
        }

        return redirect()->to('/admin/mahasiswa')->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}