<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class CategoryController extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $categories = $this->categoryModel
            ->select('categories.*, COUNT(products.id_product) AS product_count')
            ->join('products', 'products.id_category = categories.id_category', 'left')
            ->groupBy('categories.id_category')
            ->orderBy('categories.id_category', 'ASC')
            ->findAll();

        return view('admin/categories/index', [
            'title'      => 'Manajemen Kategori — ShopEase Admin',
            'activeMenu' => 'admin_categories',
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('admin/categories/create', [
            'title'      => 'Tambah Kategori — ShopEase Admin',
            'activeMenu' => 'admin_categories',
        ]);
    }

    public function store()
    {
        $rules = [
            'name' => [
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => 'Nama kategori wajib diisi.',
                    'min_length' => 'Nama kategori minimal 3 karakter.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $name = trim((string) $this->request->getPost('name'));
        $slug = url_title($name, '-', true);
        if ($this->categoryModel->where('slug', $slug)->countAllResults() > 0) {
            $slug .= '-' . time();
        }

        $this->categoryModel->insert([
            'name'        => $name,
            'slug'        => $slug,
            'icon'        => trim((string) $this->request->getPost('icon')) ?: 'bi-box-seam',
            'description' => trim((string) $this->request->getPost('description')),
        ]);

        return redirect()->to('/admin/categories')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = $this->categoryModel->find((int) $id);
        if (!$category) {
            throw PageNotFoundException::forPageNotFound('Kategori tidak ditemukan.');
        }

        return view('admin/categories/edit', [
            'title'      => 'Edit Kategori — ShopEase Admin',
            'activeMenu' => 'admin_categories',
            'category'   => $category,
        ]);
    }

    public function update($id)
    {
        $category = $this->categoryModel->find((int) $id);
        if (!$category) {
            throw PageNotFoundException::forPageNotFound('Kategori tidak ditemukan.');
        }

        $rules = ['name' => 'required|min_length[3]|max_length[100]'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $name = trim((string) $this->request->getPost('name'));
        $slug = url_title($name, '-', true);
        $dup  = $this->categoryModel->where('slug', $slug)->where('id_category !=', (int) $id)->countAllResults();
        if ($dup > 0) {
            $slug .= '-' . $id;
        }

        $this->categoryModel->update((int) $id, [
            'name'        => $name,
            'slug'        => $slug,
            'icon'        => trim((string) $this->request->getPost('icon')) ?: 'bi-box-seam',
            'description' => trim((string) $this->request->getPost('description')),
        ]);

        return redirect()->to('/admin/categories')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        $productModel = new ProductModel();
        $hasProducts  = $productModel->where('id_category', (int) $id)->countAllResults();

        if ($hasProducts > 0) {
            return redirect()->back()
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki ' . $hasProducts . ' produk.');
        }

        $this->categoryModel->delete((int) $id);

        return redirect()->to('/admin/categories')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}