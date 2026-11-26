<?php /** @var int $totalUsers @var int $totalCustomers @var int $totalOperators */ ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 mb-2">
                    ROLE: ADMINISTRATOR
                </span>
                <h1 class="fw-bold mb-1">Dashboard Admin ShopEase</h1>
                <p class="text-secondary mb-0">
                    Login sebagai <strong class="text-white"><?= esc(session()->get('name')) ?></strong> (<?= esc(session()->get('email')) ?>)
                </p>
            </div>
            <form action="<?= site_url('logout') ?>" method="POST">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-outline-danger btn-sm px-3">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card-gaming p-4">
                    <div class="small text-secondary mb-1">Total Akun Terdaftar</div>
                    <div class="brand-font fs-2 fw-bold text-info"><?= $totalUsers ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-gaming p-4">
                    <div class="small text-secondary mb-1">Total Customer</div>
                    <div class="brand-font fs-2 fw-bold text-white"><?= $totalCustomers ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-gaming p-4">
                    <div class="small text-secondary mb-1">Total Operator</div>
                    <div class="brand-font fs-2 fw-bold text-white"><?= $totalOperators ?></div>
                </div>
            </div>
        </div>

        <div class="card-gaming p-4">
            <h5 class="fw-bold text-info mb-2"><i class="bi bi-tools me-2"></i>Kesiapan Modul Week 12</h5>
            <p class="text-secondary small mb-0">
                Halaman ini sudah terlindungi oleh <code>AuthFilter (auth:admin)</code>. Pada Week 12, menu CRUD Kategori, CRUD Produk + Upload Gambar, dan Manajemen Pesanan akan ditambahkan langsung di panel ini.
            </p>
        </div>
    </div>
</section>
<?= $this->endSection() ?>