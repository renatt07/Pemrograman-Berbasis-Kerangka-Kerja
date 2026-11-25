<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AuthController::index');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout');

$routes->group('admin', ['filter' => 'role:admin'], static function ($routes) {
    $routes->get('dashboard', 'Admin\DashboardController::index');

    // Program Studi
    $routes->get('prodi', 'Admin\ProdiController::index');
    $routes->post('prodi/store', 'Admin\ProdiController::store');
    $routes->get('prodi/edit/(:num)', 'Admin\ProdiController::edit/$1');
    $routes->post('prodi/update/(:num)', 'Admin\ProdiController::update/$1');
    $routes->post('prodi/delete/(:num)', 'Admin\ProdiController::delete/$1');

    // Dosen
    $routes->get('dosen', 'Admin\DosenController::index');
    $routes->post('dosen/store', 'Admin\DosenController::store');
    $routes->get('dosen/edit/(:num)', 'Admin\DosenController::edit/$1');
    $routes->post('dosen/update/(:num)', 'Admin\DosenController::update/$1');
    $routes->post('dosen/delete/(:num)', 'Admin\DosenController::delete/$1');

    // Mahasiswa
    $routes->get('mahasiswa', 'Admin\MahasiswaController::index');
    $routes->post('mahasiswa/store', 'Admin\MahasiswaController::store');
    $routes->get('mahasiswa/edit/(:num)', 'Admin\MahasiswaController::edit/$1');
    $routes->post('mahasiswa/update/(:num)', 'Admin\MahasiswaController::update/$1');
    $routes->post('mahasiswa/delete/(:num)', 'Admin\MahasiswaController::delete/$1');

    // Mata Kuliah
    $routes->get('matakuliah', 'Admin\MataKuliahController::index');
    $routes->post('matakuliah/store', 'Admin\MataKuliahController::store');
    $routes->get('matakuliah/edit/(:num)', 'Admin\MataKuliahController::edit/$1');
    $routes->post('matakuliah/update/(:num)', 'Admin\MataKuliahController::update/$1');
    $routes->post('matakuliah/delete/(:num)', 'Admin\MataKuliahController::delete/$1');

    // Kelas
    $routes->get('kelas', 'Admin\KelasController::index');
    $routes->post('kelas/store', 'Admin\KelasController::store');
    $routes->get('kelas/edit/(:num)', 'Admin\KelasController::edit/$1');
    $routes->post('kelas/update/(:num)', 'Admin\KelasController::update/$1');
    $routes->post('kelas/delete/(:num)', 'Admin\KelasController::delete/$1');
});

$routes->group('dosen', ['filter' => 'role:dosen'], static function ($routes) {
    $routes->get('dashboard', 'Dosen\DashboardController::index');
    $routes->get('kelas', 'Dosen\KelasController::index');
    $routes->get('kelas/(:num)', 'Dosen\KelasController::detail/$1');
    $routes->post('kelas/(:num)/nilai', 'Dosen\KelasController::simpanNilai/$1');
    $routes->get('perwalian', 'Dosen\DashboardController::perwalian');
});

$routes->group('mahasiswa', ['filter' => 'role:mahasiswa'], static function ($routes) {
    $routes->get('dashboard', 'Mahasiswa\DashboardController::index');
    $routes->get('frs', 'Mahasiswa\FrsController::index');
    $routes->post('frs/ambil', 'Mahasiswa\FrsController::ambil');
    $routes->post('frs/hapus/(:num)', 'Mahasiswa\FrsController::hapus/$1');
    $routes->get('nilai', 'Mahasiswa\NilaiController::index');
    $routes->get('cetak/frs', 'Mahasiswa\FrsController::cetakFrs');
    $routes->get('cetak/transkrip', 'Mahasiswa\NilaiController::cetakTranskrip');
});