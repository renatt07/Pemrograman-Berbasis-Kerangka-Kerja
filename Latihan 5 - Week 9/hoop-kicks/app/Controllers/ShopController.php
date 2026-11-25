<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ProductModel;

class ShopController extends BaseController
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
        $categorySlug = $this->request->getGet('category');
        $courtType    = $this->request->getGet('court');
        $keyword      = trim((string) $this->request->getGet('q'));
        $sort         = $this->request->getGet('sort');

        $products   = $this->productModel->getFiltered($categorySlug, $keyword, $courtType, $sort);
        $categories = $this->categoryModel->getAllWithProductCount();

        $spotlight = $this->productModel->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->where('products.is_featured', 1)
            ->orderBy('products.id', 'ASC')
            ->first();

        return view('shop/index', [
            'title'          => 'Basketball Footwear & Court Lab',
            'products'       => $products,
            'categories'     => $categories,
            'spotlight'      => $spotlight,
            'activeCategory' => $categorySlug,
            'activeCourt'    => $courtType,
            'keyword'        => $keyword,
            'sort'           => $sort,
            'isFiltering'    => ! empty($categorySlug) || ! empty($courtType) || ! empty($keyword),
        ]);
    }

    public function detail(string $slug)
    {
        $product = $this->productModel->getBySlug($slug);
        if (! $product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Produk tidak ditemukan.');
        }

        $sizes = array_filter(array_map('trim', explode(',', (string) $product['sizes'])));

        $related = $this->productModel->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->where('products.category_id', $product['category_id'])
            ->where('products.id !=', $product['id'])
            ->limit(4)
            ->findAll();

        return view('shop/detail', [
            'title'   => $product['name'],
            'product' => $product,
            'sizes'   => $sizes,
            'related' => $related,
        ]);
    }
}