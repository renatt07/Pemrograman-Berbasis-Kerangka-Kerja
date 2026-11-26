<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Frontend Publik (Week 10)
$routes->get('/', 'HomeController::index');
$routes->get('about', 'HomeController::about');
$routes->get('contact', 'HomeController::contact');
$routes->get('catalog', 'ProductController::catalog');
$routes->get('product/(:num)', 'ProductController::detail/$1');

// Authentication (Week 11)
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::store');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::authenticate');
$routes->post('logout', 'AuthController::logout');

// Halaman Terlindungi Role (AuthFilter)
$routes->group('admin', ['filter' => 'auth:admin'], static function ($routes) {
    $routes->get('/', 'Admin\DashboardController::index');
});

$routes->group('operator', ['filter' => 'auth:operator'], static function ($routes) {
    $routes->get('/', 'Operator\DashboardController::index');
});