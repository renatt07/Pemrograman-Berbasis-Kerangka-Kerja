<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Halaman Publik
$routes->get('/', 'Home::index');

// Autentikasi
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::attemptRegister');
$routes->get('/logout', 'AuthController::logout');

// Area Pelanggan (dilindungi AuthFilter)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('booking/(:num)', 'BookingController::create/$1');
    $routes->post('booking/store', 'BookingController::store');
    $routes->get('my-bookings', 'BookingController::myBookings');
    $routes->post('my-bookings/upload/(:num)', 'BookingController::uploadPayment/$1');
    $routes->post('my-bookings/cancel/(:num)', 'BookingController::cancel/$1');
});

// Area Admin (dilindungi AdminFilter)
$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    $routes->get('dashboard', 'Admin\DashboardController::index');

    // CRUD Lapangan
    $routes->get('courts', 'Admin\CourtController::index');
    $routes->get('courts/create', 'Admin\CourtController::create');
    $routes->post('courts/store', 'Admin\CourtController::store');
    $routes->get('courts/edit/(:num)', 'Admin\CourtController::edit/$1');
    $routes->post('courts/update/(:num)', 'Admin\CourtController::update/$1');
    $routes->post('courts/delete/(:num)', 'Admin\CourtController::delete/$1');

    // Kelola Booking
    $routes->get('bookings', 'Admin\BookingController::index');
    $routes->post('bookings/status/(:num)', 'Admin\BookingController::updateStatus/$1');
});