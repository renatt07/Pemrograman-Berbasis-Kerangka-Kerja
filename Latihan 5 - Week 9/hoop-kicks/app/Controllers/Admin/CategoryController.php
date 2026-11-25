<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        return view('admin/categories', [
            'title'      => 'Kelola Kategori',
            'categories' => $this->categoryModel->getAllWithProductCount(),
            'edit'       => null,
        ]);
    }

    public function edit(int $id)
    {
        $edit = $this->categoryModel->find($id);
        if (! $edit) {
            return redirect()->to('/admin/categories')->with('error', 'Kategori tidak ditemukan.');
        }

        return view('admin/categories', [
            'title'      => 'Edit Kategori',
            'categories' => $this->categoryModel->getAllWithProductCount(),
            'edit'       => $edit,
        ]);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[80]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = trim((string) $this->request->getPost('name'));
        $slug = $this->makeUniqueSlug($name);

        $this->categoryModel->save([
            'name'        => $name,
            'slug'        => $slug,
            'description' => trim((string) $this->request->getPost('description')),
        ]);

        return redirect()->to('/admin/categories')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        $category = $this->categoryModel->find($id);
        if (! $category) {
            return redirect()->to('/admin/categories')->with('error', 'Kategori tidak ditemukan.');
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[80]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = trim((string) $this->request->getPost('name'));
        $slug = $this->makeUniqueSlug($name, $id);

        $this->categoryModel->update($id, [
            'name'        => $name,
            'slug'        => $slug,
            'description' => trim((string) $this->request->getPost('description')),
        ]);

        return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $this->categoryModel->delete($id);
        return redirect()->to('/admin/categories')->with('success', 'Kategori beserta produk di dalamnya berhasil dihapus.');
    }

    private function makeUniqueSlug(string $text, ?int $ignoreId = null): string
    {
        $base = strtolower(trim((string) preg_replace('/[^A-Za-z0-9]+/', '-', $text), '-'));
        $slug = $base ?: 'kategori';
        $i    = 1;

        while (true) {
            $builder = $this->categoryModel->where('slug', $slug);
            if ($ignoreId !== null) {
                $builder->where('id !=', $ignoreId);
            }
            if (! $builder->first()) {
                return $slug;
            }
            $slug = $base . '-' . $i++;
        }
    }
}