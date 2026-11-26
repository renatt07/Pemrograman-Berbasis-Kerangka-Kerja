<?php

namespace App\Controllers;

use App\Libraries\DummyCatalog;
use CodeIgniter\Exceptions\PageNotFoundException;

class ProductController extends BaseController
{
    public function catalog()
    {
        $products     = DummyCatalog::products();
        $categories   = DummyCatalog::categories();
        $keyword      = trim((string) $this->request->getGet('q'));
        $selectedCat  = trim((string) $this->request->getGet('category'));
        $selectedSort = trim((string) $this->request->getGet('sort'));

        if ($selectedCat !== '') {
            $products = array_filter($products, function ($item) use ($selectedCat) {
                return $item['category_slug'] === $selectedCat;
            });
        }

        if ($keyword !== '') {
            $products = array_filter($products, function ($item) use ($keyword) {
                return stripos($item['name'], $keyword) !== false
                    || stripos($item['description'], $keyword) !== false
                    || stripos($item['category_name'], $keyword) !== false;
            });
        }

        $products = array_values($products);
        if ($selectedSort === 'price_asc') {
            usort($products, fn($a, $b) => $a['price'] <=> $b['price']);
        } elseif ($selectedSort === 'price_desc') {
            usort($products, fn($a, $b) => $b['price'] <=> $a['price']);
        }

        return view('frontend/catalog', [
            'title'        => 'Katalog Gaming Gear — ShopEase',
            'activeMenu'   => 'catalog',
            'categories'   => $categories,
            'products'     => $products,
            'keyword'      => $keyword,
            'selectedCat'  => $selectedCat,
            'selectedSort' => $selectedSort,
        ]);
    }

    public function detail($id)
    {
        $product = DummyCatalog::findProduct((int) $id);

        if (!$product) {
            throw PageNotFoundException::forPageNotFound('Produk tidak ditemukan.');
        }

        $related = array_filter(DummyCatalog::products(), function ($item) use ($product) {
            return $item['id'] !== $product['id'];
        });

        return view('frontend/detail', [
            'title'           => $product['name'] . ' — ShopEase',
            'activeMenu'      => 'catalog',
            'product'         => $product,
            'relatedProducts' => array_slice(array_values($related), 0, 4),
        ]);
    }
}