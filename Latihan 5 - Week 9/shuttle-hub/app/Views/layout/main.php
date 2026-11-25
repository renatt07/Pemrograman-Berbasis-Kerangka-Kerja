<?php
/** @var string|null $title */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Beranda') ?> — ShuttleHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/shuttlehub.css') ?>" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sh-navbar sticky-top">
        <div class="container">
            <a class="sh-brand" href="<?= base_url('/') ?>">
                <span class="sh-logo-badge">
                    <!-- Logo Shuttlecock SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g transform="rotate(35 12 12)">
                            <path d="M9 17 L5 5 L9 7 L12 3.5 L15 7 L19 5 L15 17 Z" />
                            <path d="M10.5 17 L9 7 M13.5 17 L15 7 M12 17 L12 3.8 M7.7 13 H16.3" />
                            <path d="M9 17 h6 v1.5 a3 3 0 0 1 -6 0 Z" fill="currentColor" />
                        </g>
                    </svg>
                </span>
                <span>Shuttle<span class="accent">Hub</span></span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse mt-3 mt-lg-0" id="mainNav">
                <ul class="navbar-nav mx-lg-auto gap-1">
                    <li class="nav-item">
                        <a class="nav-link <?= url_is('/') ? 'active' : '' ?>" href="<?= base_url('/') ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/#daftar-lapangan') ?>">Lapangan</a>
                    </li>
                    <?php if (session()->get('isLoggedIn')) : ?>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('my-bookings*') ? 'active' : '' ?>" href="<?= base_url('/my-bookings') ?>">Booking Saya</a>
                        </li>
                    <?php endif; ?>
                    <?php if (session()->get('role') === 'admin') : ?>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" style="color: var(--sh-lime);" href="<?= base_url('/admin/dashboard') ?>">
                                <i class="bi bi-speedometer2 me-1"></i>Panel Admin
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                    <?php if (session()->get('isLoggedIn')) : ?>
                        <span class="text-white-50 small me-1 d-none d-lg-inline">
                            Halo, <strong class="text-white"><?= esc(session()->get('name')) ?></strong>
                        </span>
                        <a href="<?= base_url('/logout') ?>" class="btn btn-outline-light btn-sm px-3">Keluar</a>
                    <?php else : ?>
                        <a href="<?= base_url('/login') ?>" class="btn btn-outline-light btn-sm px-3">Masuk</a>
                        <a href="<?= base_url('/register') ?>" class="btn btn-lime btn-sm px-3">Daftar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Notifikasi Flashdata -->
    <?php if (session()->getFlashdata('success') || session()->getFlashdata('error') || session()->getFlashdata('errors')) : ?>
        <div class="container mt-3">
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?= esc(session()->getFlashdata('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= esc(session()->getFlashdata('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show" role="alert">
                    <ul class="mb-0 ps-3">
                        <?php foreach (session()->getFlashdata('errors') as $err) : ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Konten Utama -->
    <main class="flex-grow-1">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="sh-footer py-4 mt-5">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 small">
                <div class="d-flex align-items-center gap-2 text-white fw-semibold">
                    <span class="sh-logo-badge" style="width: 28px; height: 28px; border-radius: 7px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <g transform="rotate(35 12 12)">
                                <path d="M9 17 L5 5 L9 7 L12 3.5 L15 7 L19 5 L15 17 Z" />
                                <path d="M10.5 17 L9 7 M13.5 17 L15 7 M12 17 L12 3.8 M7.7 13 H16.3" />
                                <path d="M9 17 h6 v1.5 a3 3 0 0 1 -6 0 Z" fill="currentColor" />
                            </g>
                        </svg>
                    </span>
                    <span>ShuttleHub Arena Badminton</span>
                </div>
                <div>Buka Setiap Hari 07:00 – 22:00 WIB &middot; &copy; <?= date('Y') ?> ShuttleHub</div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>