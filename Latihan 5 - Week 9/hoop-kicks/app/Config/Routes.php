<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Storefront Publik
$routes->get('/', 'ShopController::index');
$routes->get('/product/(:segment)', 'ShopController::detail/$1');

// Keranjang Belanja (Session)
$routes->get('/cart', 'CartController::index');
$routes->post('/cart/add', 'CartController::add');
$routes->post('/cart/update', 'CartController::update');
$routes->post('/cart/remove/(:segment)', 'CartController::remove/$1');

// Autentikasi
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::attemptRegister');
$routes->get('/logout', 'AuthController::logout');

// Checkout & Riwayat Pesanan (Wajib Login)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('checkout', 'OrderController::checkout');
    $routes->post('checkout', 'OrderController::placeOrder');
    $routes->get('my-orders', 'OrderController::myOrders');
});

// Panel Admin (dilindungi AdminFilter)
$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    $routes->get('dashboard', 'Admin\DashboardController::index');

    // Kategori
    $routes->get('categories', 'Admin\CategoryController::index');
    $routes->post('categories/store', 'Admin\CategoryController::store');
    $routes->get('categories/edit/(:num)', 'Admin\CategoryController::edit/$1');
    $routes->post('categories/update/(:num)', 'Admin\CategoryController::update/$1');
    $routes->post('categories/delete/(:num)', 'Admin\CategoryController::delete/$1');

    // Produk
    $routes->get('products', 'Admin\ProductController::index');
    $routes->get('products/create', 'Admin\ProductController::create');
    $routes->post('products/store', 'Admin\ProductController::store');
    $routes->get('products/edit/(:num)', 'Admin\ProductController::edit/$1');
    $routes->post('products/update/(:num)', 'Admin\ProductController::update/$1');
    $routes->post('products/delete/(:num)', 'Admin\ProductController::delete/$1');

    // Pesanan
    $routes->get('orders', 'Admin\OrderController::index');
    $routes->post('orders/status/(:num)', 'Admin\OrderController::updateStatus/$1');
});