<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ProductController extends BaseController
{
    public function catalog()
    {
        $categoryModel = new CategoryModel();
        $productModel  = new ProductModel();

        $keyword      = trim((string) $this->request->getGet('q'));
        $selectedCat  = trim((string) $this->request->getGet('category'));
        $selectedSort = trim((string) $this->request->getGet('sort'));

        $productModel
            ->select('products.*, categories.name AS category_name, categories.slug AS category_slug')
            ->join('categories', 'categories.id_category = products.id_category')
            ->where('products.status', 'tersedia');

        if ($selectedCat !== '') {
            $productModel->where('categories.slug', $selectedCat);
        }

        if ($keyword !== '') {
            $productModel->groupStart()
                ->like('products.name', $keyword)
                ->orLike('products.description', $keyword)
                ->orLike('categories.name', $keyword)
                ->groupEnd();
        }

        if ($selectedSort === 'price_asc') {
            $productModel->orderBy('products.price', 'ASC');
        } elseif ($selectedSort === 'price_desc') {
            $productModel->orderBy('products.price', 'DESC');
        } else {
            $productModel->orderBy('products.id_product', 'DESC');
        }

        $products = $productModel->paginate(8, 'catalog');
        $pager    = $productModel->pager;
        $products = $productModel->attachImages($products);

        return view('frontend/catalog', [
            'title'        => 'Katalog Gaming Gear — ShopEase',
            'activeMenu'   => 'catalog',
            'categories'   => $categoryModel->orderBy('name', 'ASC')->findAll(),
            'products'     => $products,
            'pager'        => $pager,
            'keyword'      => $keyword,
            'selectedCat'  => $selectedCat,
            'selectedSort' => $selectedSort,
        ]);
    }

    public function detail($id)
    {
        $productModel = new ProductModel();

        $product = $productModel
            ->select('products.*, categories.name AS category_name, categories.slug AS category_slug')
            ->join('categories', 'categories.id_category = products.id_category')
            ->where('products.status', 'tersedia')
            ->find((int) $id);

        if (!$product) {
            throw PageNotFoundException::forPageNotFound('Produk tidak ditemukan.');
        }

        $product = $productModel->attachImages([$product])[0];

        $related = $productModel
            ->select('products.*, categories.name AS category_name')
            ->join('categories', 'categories.id_category = products.id_category')
            ->where('products.status', 'tersedia')
            ->where('products.id_product !=', $product['id_product'])
            ->orderBy('products.id_product', 'DESC')
            ->findAll(4);

        $related = $productModel->attachImages($related);

        return view('frontend/detail', [
            'title'           => $product['name'] . ' — ShopEase',
            'activeMenu'      => 'catalog',
            'product'         => $product,
            'relatedProducts' => $related,
        ]);
    }
}