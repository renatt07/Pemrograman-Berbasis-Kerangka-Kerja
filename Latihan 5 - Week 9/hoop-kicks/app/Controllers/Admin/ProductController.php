<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class ProductController extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $products = $this->productModel->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->orderBy('products.id', 'DESC')
            ->findAll();

        return view('admin/products/index', [
            'title'    => 'Kelola Produk',
            'products' => $products,
        ]);
    }

    public function create()
    {
        return view('admin/products/form', [
            'title'      => 'Tambah Produk',
            'categories' => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
            'product'    => null,
        ]);
    }

    public function store()
    {
        $rules = [
            'category_id' => 'required|integer',
            'sku'         => 'required|max_length[40]|is_unique[products.sku]',
            'name'        => 'required|min_length[3]|max_length[150]',
            'brand'       => 'required|max_length[60]',
            'colorway'    => 'required|max_length[100]',
            'court_type'  => 'required|in_list[Indoor,Outdoor,All-Court]',
            'price'       => 'required|integer|greater_than[0]',
            'stock'       => 'required|integer|greater_than_equal_to[0]',
            'sizes'       => 'required|max_length[100]',
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
            $uploadDir = FCPATH . 'uploads/products';
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $imageName = $imageFile->getRandomName();
            $imageFile->move($uploadDir, $imageName);
        }

        $name = trim((string) $this->request->getPost('name'));
        $sku  = strtoupper(trim((string) $this->request->getPost('sku')));

        $this->productModel->save([
            'category_id' => $this->request->getPost('category_id'),
            'sku'         => $sku,
            'name'        => $name,
            'slug'        => $this->makeUniqueSlug($name . '-' . $sku),
            'brand'       => trim((string) $this->request->getPost('brand')),
            'colorway'    => trim((string) $this->request->getPost('colorway')),
            'court_type'  => $this->request->getPost('court_type'),
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'sizes'       => trim((string) $this->request->getPost('sizes')),
            'description' => trim((string) $this->request->getPost('description')),
            'image'       => $imageName,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
        ]);

        return redirect()->to('/admin/products')->with('success', 'Produk baru berhasil ditambahkan ke katalog.');
    }

    public function edit(int $id)
    {
        $product = $this->productModel->find($id);
        if (! $product) {
            return redirect()->to('/admin/products')->with('error', 'Produk tidak ditemukan.');
        }

        return view('admin/products/form', [
            'title'      => 'Edit Produk',
            'categories' => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
            'product'    => $product,
        ]);
    }

    public function update(int $id)
    {
        $product = $this->productModel->find($id);
        if (! $product) {
            return redirect()->to('/admin/products')->with('error', 'Produk tidak ditemukan.');
        }

        $rules = [
            'category_id' => 'required|integer',
            'sku'         => "required|max_length[40]|is_unique[products.sku,id,{$id}]",
            'name'        => 'required|min_length[3]|max_length[150]',
            'brand'       => 'required|max_length[60]',
            'colorway'    => 'required|max_length[100]',
            'court_type'  => 'required|in_list[Indoor,Outdoor,All-Court]',
            'price'       => 'required|integer|greater_than[0]',
            'stock'       => 'required|integer|greater_than_equal_to[0]',
            'sizes'       => 'required|max_length[100]',
        ];

        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['image'] = 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageName = $product['image'];
        if ($imageFile && $imageFile->isValid() && ! $imageFile->hasMoved()) {
            $uploadDir = FCPATH . 'uploads/products';
            if (! is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            if (! empty($product['image']) && is_file($uploadDir . '/' . $product['image'])) {
                unlink($uploadDir . '/' . $product['image']);
            }
            $imageName = $imageFile->getRandomName();
            $imageFile->move($uploadDir, $imageName);
        }

        $name = trim((string) $this->request->getPost('name'));
        $sku  = strtoupper(trim((string) $this->request->getPost('sku')));

        $this->productModel->update($id, [
            'category_id' => $this->request->getPost('category_id'),
            'sku'         => $sku,
            'name'        => $name,
            'slug'        => $this->makeUniqueSlug($name . '-' . $sku, $id),
            'brand'       => trim((string) $this->request->getPost('brand')),
            'colorway'    => trim((string) $this->request->getPost('colorway')),
            'court_type'  => $this->request->getPost('court_type'),
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'sizes'       => trim((string) $this->request->getPost('sizes')),
            'description' => trim((string) $this->request->getPost('description')),
            'image'       => $imageName,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
        ]);

        return redirect()->to('/admin/products')->with('success', 'Data produk berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $product = $this->productModel->find($id);
        if (! $product) {
            return redirect()->to('/admin/products')->with('error', 'Produk tidak ditemukan.');
        }

        if (! empty($product['image']) && is_file(FCPATH . 'uploads/products/' . $product['image'])) {
            unlink(FCPATH . 'uploads/products/' . $product['image']);
        }

        $this->productModel->delete($id);

        return redirect()->to('/admin/products')->with('success', 'Produk berhasil dihapus.');
    }

    private function makeUniqueSlug(string $text, ?int $ignoreId = null): string
    {
        $base = strtolower(trim((string) preg_replace('/[^A-Za-z0-9]+/', '-', $text), '-'));
        $slug = $base ?: 'produk';
        $i    = 1;

        while (true) {
            $builder = $this->productModel->where('slug', $slug);
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