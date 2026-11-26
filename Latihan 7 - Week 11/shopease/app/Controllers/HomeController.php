<?php

namespace App\Controllers;

use App\Libraries\DummyCatalog;

class HomeController extends BaseController
{
    public function index()
    {
        $products = DummyCatalog::products();

        return view('frontend/home', [
            'title'            => 'ShopEase — Pro Gaming Gear & Desk Setup',
            'activeMenu'       => 'home',
            'categories'       => DummyCatalog::categories(),
            'featuredProducts' => array_slice($products, 0, 4), 'latestProducts'   => array_slice($products, 4, 4),
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