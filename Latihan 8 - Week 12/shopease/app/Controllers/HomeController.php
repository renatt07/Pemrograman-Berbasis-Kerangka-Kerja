<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;

class HomeController extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $productModel  = new ProductModel();

        $categories = $categoryModel->orderBy('id_category', 'ASC')->findAll();

        $allProducts = $productModel
            ->select('products.*, categories.name AS category_name, categories.slug AS category_slug')
            ->join('categories', 'categories.id_category = products.id_category')
            ->where('products.status', 'tersedia')
            ->orderBy('products.id_product', 'ASC')
            ->findAll();

        $allProducts = $productModel->attachImages($allProducts);

        // Hero featured: pilih Pulsar Susanto-X jika ada, kalau tidak ambil produk pertama
        $heroProduct = $allProducts[0] ?? null;
        foreach ($allProducts as $p) {
            if (stripos($p['name'], 'Susanto') !== false) {
                $heroProduct = $p;
                break;
            }
        }

        return view('frontend/home', [
            'title'            => 'ShopEase — Pro Gaming Gear & Desk Setup',
            'activeMenu'       => 'home',
            'categories'       => $categories,
            'heroProduct'      => $heroProduct,
            'featuredProducts' => array_slice($allProducts, 0, 4),
            'latestProducts'   => array_slice($allProducts, 4, 4),
        ]);
    }

    public function about()
    {
        return view('frontend/about', [
            'title'      => 'Tentang Kami — ShopEase Gaming Gear',
            'activeMenu' => 'about',
        ]);
    }

    public function contact()
    {
        return view('frontend/contact', [
            'title'      => 'Hubungi Kami — ShopEase Gaming Gear',
            'activeMenu' => 'contact',
        ]);
    }
}