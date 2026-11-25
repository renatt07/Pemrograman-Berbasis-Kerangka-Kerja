<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CourtModel;

class CourtController extends BaseController
{
    protected $courtModel;

    public function __construct()
    {
        $this->courtModel = new CourtModel();
    }

    public function index()
    {
        return view('admin/courts/index', [
            'title'  => 'Kelola Lapangan',
            'courts' => $this->courtModel->orderBy('id', 'DESC')->findAll(),
        ]);
    }

    public function create()
    {
        return view('admin/courts/form', [
            'title' => 'Tambah Lapangan',
            'court' => null,
        ]);
    }

    public function store()
    {
        $rules = [
            'name'           => 'required|min_length[3]|max_length[100]',
            'floor_type'     => 'required|max_length[50]',
            'price_per_hour' => 'required|integer|greater_than[0]',
            'status'         => 'required|in_list[available,maintenance]',
        ];

        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['image'] = 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageName = null;
        if ($imageFile && $imageFile->isValid() && ! $imageFile->hasMoved()) {
            $uploadDir = FCPATH . 'uploads/courts';
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $imageName = $imageFile->getRandomName();
            $imageFile->move($uploadDir, $imageName);
        }

        $this->courtModel->save([
            'name'           => $this->request->getPost('name'),
            'floor_type'     => $this->request->getPost('floor_type'),
            'price_per_hour' => $this->request->getPost('price_per_hour'),
            'description'    => $this->request->getPost('description'),
            'status'         => $this->request->getPost('status'),
            'image'          => $imageName,
        ]);

        return redirect()->to('/admin/courts')->with('success', 'Lapangan baru berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $court = $this->courtModel->find($id);
        if (! $court) {
            return redirect()->to('/admin/courts')->with('error', 'Data lapangan tidak ditemukan.');
        }

        return view('admin/courts/form', [
            'title' => 'Edit Lapangan',
            'court' => $court,
        ]);
    }

    public function update(int $id)
    {
        $court = $this->courtModel->find($id);
        if (! $court) {
            return redirect()->to('/admin/courts')->with('error', 'Data lapangan tidak ditemukan.');
        }

        $rules = [
            'name'           => 'required|min_length[3]|max_length[100]',
            'floor_type'     => 'required|max_length[50]',
            'price_per_hour' => 'required|integer|greater_than[0]',
            'status'         => 'required|in_list[available,maintenance]',
        ];

        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['image'] = 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageName = $court['image'];
        if ($imageFile && $imageFile->isValid() && ! $imageFile->hasMoved()) {
            $uploadDir = FCPATH . 'uploads/courts';
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Hapus foto lama jika ada
            if (! empty($court['image']) && is_file($uploadDir . '/' . $court['image'])) {
                unlink($uploadDir . '/' . $court['image']);
            }

            $imageName = $imageFile->getRandomName();
            $imageFile->move($uploadDir, $imageName);
        }

        $this->courtModel->update($id, [
            'name'           => $this->request->getPost('name'),
            'floor_type'     => $this->request->getPost('floor_type'),
            'price_per_hour' => $this->request->getPost('price_per_hour'),
            'description'    => $this->request->getPost('description'),
            'status'         => $this->request->getPost('status'),
            'image'          => $imageName,
        ]);

        return redirect()->to('/admin/courts')->with('success', 'Data lapangan berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $court = $this->courtModel->find($id);
        if (! $court) {
            return redirect()->to('/admin/courts')->with('error', 'Data lapangan tidak ditemukan.');
        }

        if (! empty($court['image']) && is_file(FCPATH . 'uploads/courts/' . $court['image'])) {
            unlink(FCPATH . 'uploads/courts/' . $court['image']);
        }

        $this->courtModel->delete($id);

        return redirect()->to('/admin/courts')->with('success', 'Lapangan berhasil dihapus.');
    }
}