<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ProductController extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $imageModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->imageModel    = new ProductImageModel();
    }

    public function index()
    {
        $keyword     = trim((string) $this->request->getGet('q'));
        $selectedCat = trim((string) $this->request->getGet('category'));

        $this->productModel
            ->select('products.*, categories.name AS category_name')
            ->join('categories', 'categories.id_category = products.id_category');

        if ($selectedCat !== '') {
            $this->productModel->where('products.id_category', (int) $selectedCat);
        }

        if ($keyword !== '') {
            $this->productModel->like('products.name', $keyword);
        }

        $products = $this->productModel->orderBy('products.id_product', 'DESC')->findAll();
        $products = $this->productModel->attachImages($products);

        return view('admin/products/index', [
            'title'       => 'Manajemen Produk — ShopEase Admin',
            'activeMenu'  => 'admin_products',
            'products'    => $products,
            'categories'  => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
            'keyword'     => $keyword,
            'selectedCat' => $selectedCat,
        ]);
    }

    public function create()
    {
        return view('admin/products/create', [
            'title'      => 'Tambah Produk — ShopEase Admin',
            'activeMenu' => 'admin_products',
            'categories' => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
        ]);
    }

    public function store()
    {
        $rules = [
            'id_category' => 'required|is_natural_no_zero|is_not_unique[categories.id_category]',
            'name'        => 'required|min_length[3]|max_length[150]',
            'price'       => 'required|decimal|greater_than_equal_to[0]',
            'stock'       => 'required|is_natural',
            'status'      => 'required|in_list[tersedia,tidak_tersedia]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $name = trim((string) $this->request->getPost('name'));
            $slug = url_title($name, '-', true);
            if ($this->productModel->where('slug', $slug)->countAllResults() > 0) {
                $slug .= '-' . time();
            }

            $id = $this->productModel->insert([
                'id_category' => (int) $this->request->getPost('id_category'),
                'name'        => $name,
                'slug'        => $slug,
                'description' => trim((string) $this->request->getPost('description')),
                'specs'       => $this->parseSpecsToJson((string) $this->request->getPost('specs_text')),
                'price'       => $this->request->getPost('price'),
                'stock'       => (int) $this->request->getPost('stock'),
                'badge'       => trim((string) $this->request->getPost('badge')) ?: null,
                'status'      => $this->request->getPost('status'),
            ]);

            $uploadError = $this->saveImages((int) $id);
            if ($uploadError !== null) {
                $db->transRollback();
                return redirect()->back()->withInput()->with('error', $uploadError);
            }

            $db->transCommit();
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan produk: ' . $e->getMessage());
        }

        return redirect()->to('/admin/products')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $product = $this->productModel->find((int) $id);
        if (!$product) {
            throw PageNotFoundException::forPageNotFound('Produk tidak ditemukan.');
        }

        return view('admin/products/edit', [
            'title'      => 'Edit Produk — ShopEase Admin',
            'activeMenu' => 'admin_products',
            'product'    => $product,
            'specsText'  => $this->formatJsonToSpecsText((string) ($product['specs'] ?? '')),
            'categories' => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
            'images'     => $this->imageModel->where('id_product', (int) $id)->orderBy('is_primary', 'DESC')->findAll(),
        ]);
    }

    public function update($id)
    {
        $product = $this->productModel->find((int) $id);
        if (!$product) {
            throw PageNotFoundException::forPageNotFound('Produk tidak ditemukan.');
        }

        $rules = [
            'id_category' => 'required|is_natural_no_zero|is_not_unique[categories.id_category]',
            'name'        => 'required|min_length[3]|max_length[150]',
            'price'       => 'required|decimal|greater_than_equal_to[0]',
            'stock'       => 'required|is_natural',
            'status'      => 'required|in_list[tersedia,tidak_tersedia]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $name = trim((string) $this->request->getPost('name'));
        $slug = url_title($name, '-', true);
        $dup  = $this->productModel
            ->where('slug', $slug)
            ->where('id_product !=', (int) $id)
            ->countAllResults();

        if ($dup > 0) {
            $slug .= '-' . $id;
        }

        $this->productModel->update((int) $id, [
            'id_category' => (int) $this->request->getPost('id_category'),
            'name'        => $name,
            'slug'        => $slug,
            'description' => trim((string) $this->request->getPost('description')),
            'specs'       => $this->parseSpecsToJson((string) $this->request->getPost('specs_text')),
            'price'       => $this->request->getPost('price'),
            'stock'       => (int) $this->request->getPost('stock'),
            'badge'       => trim((string) $this->request->getPost('badge')) ?: null,
            'status'      => $this->request->getPost('status'),
        ]);

        $uploadError = $this->saveImages((int) $id);
        if ($uploadError !== null) {
            return redirect()->back()->with('error', $uploadError);
        }

        return redirect()->to('/admin/products')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function delete($id)
    {
        $product = $this->productModel->find((int) $id);
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $images = $this->imageModel->where('id_product', (int) $id)->findAll();
        foreach ($images as $img) {
            $usedByOthers = $this->imageModel
                ->where('image', $img['image'])
                ->where('id_product !=', (int) $id)
                ->countAllResults();

            if ($usedByOthers === 0) {
                $path = FCPATH . 'uploads/products/' . $img['image'];
                if (is_file($path)) {
                    unlink($path);
                }
            }
        }

        $this->productModel->delete((int) $id);

        return redirect()->to('/admin/products')
            ->with('success', 'Produk berhasil dihapus.');
    }

    public function deleteImage($imageId)
    {
        $image = $this->imageModel->find((int) $imageId);
        if (!$image) {
            return redirect()->back()->with('error', 'Gambar tidak ditemukan.');
        }

        $usedByOthers = $this->imageModel
            ->where('image', $image['image'])
            ->where('id_image !=', (int) $imageId)
            ->countAllResults();

        if ($usedByOthers === 0) {
            $path = FCPATH . 'uploads/products/' . $image['image'];
            if (is_file($path)) {
                unlink($path);
            }
        }

        $this->imageModel->delete((int) $imageId);

        // Jika gambar utama dihapus, jadikan gambar tersisa pertama sebagai utama
        if ((int) $image['is_primary'] === 1) {
            $next = $this->imageModel->where('id_product', $image['id_product'])->first();
            if ($next) {
                $this->imageModel->update($next['id_image'], ['is_primary' => 1]);
            }
        }

        return redirect()->back()->with('success', 'Gambar produk berhasil dihapus.');
    }

    public function setPrimaryImage($imageId)
    {
        $image = $this->imageModel->find((int) $imageId);
        if (!$image) {
            return redirect()->back()->with('error', 'Gambar tidak ditemukan.');
        }

        $this->imageModel->where('id_product', $image['id_product'])->set(['is_primary' => 0])->update();
        $this->imageModel->update((int) $imageId, ['is_primary' => 1]);

        return redirect()->back()->with('success', 'Gambar utama berhasil diperbarui.');
    }

    private function saveImages(int $productId): ?string
    {
        $files = $this->request->getFileMultiple('images');
        if (!$files) {
            return null;
        }

        $directory = FCPATH . 'uploads/products/';
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $hasPrimary = $this->imageModel
            ->where('id_product', $productId)
            ->where('is_primary', 1)
            ->countAllResults() > 0;

        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];

        foreach ($files as $file) {
            if ($file->getError() === UPLOAD_ERR_NO_FILE) {
                continue;
            }
            if (!$file->isValid() || $file->hasMoved()) {
                return 'File gambar gagal diunggah.';
            }
            if (!in_array($file->getMimeType(), $allowedMimes, true)) {
                return 'Format gambar harus JPG, PNG, atau WEBP.';
            }
            if ($file->getSizeByUnit('mb') > 2) {
                return 'Ukuran gambar maksimal 2 MB per file.';
            }

            $filename = $file->getRandomName();
            $file->move($directory, $filename);

            $this->imageModel->insert([
                'id_product' => $productId,
                'image'      => $filename,
                'is_primary' => $hasPrimary ? 0 : 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $hasPrimary = true;
        }

        return null;
    }

    private function parseSpecsToJson(string $raw): ?string
    {
        $lines = preg_split('/\r\n|\r|\n/', trim($raw));
        $specs = [];
        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                [$key, $val] = explode(':', $line, 2);
                $key = trim($key);
                $val = trim($val);
                if ($key !== '' && $val !== '') {
                    $specs[$key] = $val;
                }
            }
        }

        return empty($specs) ? null : json_encode($specs);
    }

    private function formatJsonToSpecsText(string $json): string
    {
        $decoded = json_decode($json, true);
        if (!is_array($decoded)) {
            return '';
        }

        $lines = [];
        foreach ($decoded as $k => $v) {
            $lines[] = $k . ': ' . $v;
        }

        return implode("\n", $lines);
    }
}