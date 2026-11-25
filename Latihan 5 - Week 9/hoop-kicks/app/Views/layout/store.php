<?php
/** @var string|null $title */
$cart      = session()->get('cart') ?? [];
$cartCount = array_sum(array_column($cart, 'quantity'));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Store') ?> — HOOPKICKS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/hoopkicks.css') ?>" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Marquee Ticker -->
    <div class="hk-marquee">
        <div class="hk-marquee-track">
            SEASON 26 BASKETBALL DROP &nbsp;&bull;&nbsp; 100% AUTHENTIC PERFORMANCE PAIRS &nbsp;&bull;&nbsp; FREE DOUBLE-BOX SHIPPING SURABAYA &nbsp;&bull;&nbsp; INDOOR &amp; OUTDOOR COURT TESTED &nbsp;&bull;&nbsp;
            SEASON 26 BASKETBALL DROP &nbsp;&bull;&nbsp; 100% AUTHENTIC PERFORMANCE PAIRS &nbsp;&bull;&nbsp; FREE DOUBLE-BOX SHIPPING SURABAYA &nbsp;&bull;&nbsp; INDOOR &amp; OUTDOOR COURT TESTED &nbsp;&bull;&nbsp;
        </div>
    </div>

    <!-- Navbar -->
    <header class="hk-nav sticky-top">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <a href="<?= base_url('/') ?>" class="hk-brand">HOOP<span>KICKS</span></a>

                <nav class="d-flex align-items-center gap-1 gap-md-2">
                    <a href="<?= base_url('/') ?>" class="hk-nav-link <?= url_is('/') ? 'active' : '' ?>">Home</a>
                    <a href="<?= base_url('/#catalog') ?>" class="hk-nav-link">Catalog</a>
                    <?php if (session()->get('isLoggedIn')) : ?>
                        <a href="<?= base_url('/my-orders') ?>" class="hk-nav-link <?= url_is('my-orders*') ? 'active' : '' ?>">Orders</a>
                    <?php endif; ?>
                    <?php if (session()->get('role') === 'admin') : ?>
                        <a href="<?= base_url('/admin/dashboard') ?>" class="hk-nav-link" style="background: var(--hk-accent); color: #FFF;">Admin</a>
                    <?php endif; ?>
                </nav>

                <div class="d-flex align-items-center gap-2">
                    <a href="<?= base_url('/cart') ?>" class="hk-btn hk-btn-outline hk-btn-sm">
                        <i class="bi bi-bag"></i>
                        <span>BAG [<?= $cartCount ?>]</span>
                    </a>

                    <?php if (session()->get('isLoggedIn')) : ?>
                        <span class="font-mono small text-muted d-none d-lg-inline ms-1"><?= esc(session()->get('name')) ?></span>
                        <a href="<?= base_url('/logout') ?>" class="hk-btn hk-btn-dark hk-btn-sm">Logout</a>
                    <?php else : ?>
                        <a href="<?= base_url('/login') ?>" class="hk-btn hk-btn-dark hk-btn-sm">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Flash Alerts -->
    <?php if (session()->getFlashdata('success') || session()->getFlashdata('error') || session()->getFlashdata('errors')) : ?>
        <div class="container mt-3">
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success border border-dark d-flex justify-content-between align-items-center py-2 mb-0">
                    <span class="small fw-semibold"><?= esc(session()->getFlashdata('success')) ?></span>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger border border-dark d-flex justify-content-between align-items-center py-2 mb-0">
                    <span class="small fw-semibold"><?= esc(session()->getFlashdata('error')) ?></span>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger border border-dark py-2 mb-0 small">
                    <ul class="mb-0 ps-3">
                        <?php foreach (session()->getFlashdata('errors') as $err) : ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="flex-grow-1">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="mt-5 border-top border-dark bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4 align-items-end">
                <div class="col-md-6">
                    <div class="hk-brand text-white mb-2">HOOP<span>KICKS</span></div>
                    <p class="small text-white-50 mb-0 col-lg-9">
                        Specialty basketball footwear boutique. Kurasi sepatu performa untuk guard cepat, wing eksplosif, dan pejuang lapangan outdoor.
                    </p>
                </div>
                <div class="col-md-6 text-md-end font-mono small text-white-50">
                    <div>SURABAYA COURT LAB // OPEN DAILY 10:00–21:00</div>
                    <div class="mt-1">&copy; <?= date('Y') ?> HOOPKICKS STORE</div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>