<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Frontend Publik
$routes->get('/', 'HomeController::index');
$routes->get('about', 'HomeController::about');
$routes->get('contact', 'HomeController::contact');
$routes->get('catalog', 'ProductController::catalog');
$routes->get('product/(:num)', 'ProductController::detail/$1');

// Authentication
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::store');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::authenticate');
$routes->post('logout', 'AuthController::logout');

// Area Customer Login (Shopping Cart, Checkout, & Riwayat Pesanan)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('cart', 'CartController::index');
    $routes->post('cart/add', 'CartController::add');
    $routes->post('cart/update/(:num)', 'CartController::update/$1');
    $routes->post('cart/remove/(:num)', 'CartController::remove/$1');

    $routes->get('checkout', 'CheckoutController::index');
    $routes->post('checkout/process', 'CheckoutController::process');

    $routes->get('orders', 'OrderController::index');
    $routes->get('orders/(:num)', 'OrderController::detail/$1');
    $routes->post('orders/(:num)/payment', 'OrderController::uploadPayment/$1');
    $routes->post('orders/(:num)/complete', 'OrderController::complete/$1');
});

// Dashboard & Aksi Khusus Admin
$routes->group('admin', ['filter' => 'auth:admin'], static function ($routes) {
    $routes->get('/', 'Admin\DashboardController::index');
    $routes->post('orders/(:num)/verify-payment', 'Admin\OrderController::verifyPayment/$1');
});

// Dashboard Khusus Operator
$routes->group('operator', ['filter' => 'auth:operator'], static function ($routes) {
    $routes->get('/', 'Operator\DashboardController::index');
});

// Manajemen Kategori, Produk, & Pengiriman Pesanan (Admin & Operator)
$routes->group('admin', ['filter' => 'auth:admin,operator'], static function ($routes) {
    // CRUD Kategori
    $routes->get('categories', 'Admin\CategoryController::index');
    $routes->get('categories/create', 'Admin\CategoryController::create');
    $routes->post('categories/store', 'Admin\CategoryController::store');
    $routes->get('categories/edit/(:num)', 'Admin\CategoryController::edit/$1');
    $routes->post('categories/update/(:num)', 'Admin\CategoryController::update/$1');
    $routes->post('categories/delete/(:num)', 'Admin\CategoryController::delete/$1');

    // CRUD Produk & Galeri Gambar
    $routes->get('products', 'Admin\ProductController::index');
    $routes->get('products/create', 'Admin\ProductController::create');
    $routes->post('products/store', 'Admin\ProductController::store');
    $routes->get('products/edit/(:num)', 'Admin\ProductController::edit/$1');
    $routes->post('products/update/(:num)', 'Admin\ProductController::update/$1');
    $routes->post('products/delete/(:num)', 'Admin\ProductController::delete/$1');
    $routes->post('products/images/delete/(:num)', 'Admin\ProductController::deleteImage/$1');
    $routes->post('products/images/primary/(:num)', 'Admin\ProductController::setPrimaryImage/$1');

    // Order & Shipment Management
    $routes->get('orders', 'Admin\OrderController::index');
    $routes->get('orders/(:num)', 'Admin\OrderController::detail/$1');
    $routes->post('orders/(:num)/shipment', 'Admin\OrderController::updateShipment/$1');
    $routes->post('orders/(:num)/cancel', 'Admin\OrderController::cancel/$1');
});