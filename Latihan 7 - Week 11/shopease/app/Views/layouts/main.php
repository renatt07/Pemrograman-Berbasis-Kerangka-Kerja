<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'ShopEase — Gaming Gear') ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-gaming sticky-top py-3">
    <div class="container">
        <a class="navbar-brand brand-font fs-4 fw-bold d-flex align-items-center gap-2" href="<?= site_url('/') ?>">
            <i class="bi bi-controller brand-accent"></i>
            <span>Shop<span class="brand-accent">Ease</span></span>
        </a>

        <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto ms-lg-4 mb-2 mb-lg-0 gap-lg-2">
                <li class="nav-item">
                    <a class="nav-link <?= ($activeMenu ?? '') === 'home' ? 'active' : '' ?>" href="<?= site_url('/') ?>">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($activeMenu ?? '') === 'catalog' ? 'active' : '' ?>" href="<?= site_url('catalog') ?>">Katalog Gear</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($activeMenu ?? '') === 'about' ? 'active' : '' ?>" href="<?= site_url('about') ?>">Tentang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($activeMenu ?? '') === 'contact' ? 'active' : '' ?>" href="<?= site_url('contact') ?>">Kontak</a>
                </li>
            </ul>

            <form action="<?= site_url('catalog') ?>" method="GET" class="d-flex me-lg-3 my-2 my-lg-0">
                <div class="input-group input-group-sm">
                    <input type="text" name="q" class="form-control" placeholder="Cari keyboard, mouse..." value="<?= esc($keyword ?? '') ?>">
                    <button class="btn btn-outline-cyber" type="submit" aria-label="Cari">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <div class="d-flex align-items-center gap-2 mt-2 mt-lg-0">
            <button type="button" class="btn btn-outline-secondary btn-sm position-relative me-2" data-bs-toggle="modal" data-bs-target="#comingSoonModal" data-feature="Keranjang Belanja (Week 12)">
                <i class="bi bi-cart3 fs-6"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info text-dark" style="font-size: 0.65rem; padding: 0.25em 0.5em;">0</span>
            </button>

            <?php if (session()->get('isLoggedIn')): ?>
                <div class="dropdown">
                    <button class="btn btn-outline-cyber btn-sm dropdown-toggle d-inline-flex align-items-center gap-2 px-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                        <span><?= esc(session()->get('name')) ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark border-secondary shadow">
                        <li class="px-3 py-2 border-bottom border-secondary">
                            <div class="small fw-semibold text-white"><?= esc(session()->get('name')) ?></div>
                            <div class="text-secondary" style="font-size: 0.75rem;">Role: <?= esc(ucfirst((string) session()->get('role'))) ?></div>
                        </li>
                        <?php if (session()->get('role') === 'admin'): ?>
                            <li>
                                <a class="dropdown-item small py-2" href="<?= site_url('admin') ?>">
                                    <i class="bi bi-speedometer2 me-2 text-info"></i>Dashboard Admin
                                </a>
                            </li>
                        <?php elseif (session()->get('role') === 'operator'): ?>
                            <li>
                                <a class="dropdown-item small py-2" href="<?= site_url('operator') ?>">
                                    <i class="bi bi-box-seam me-2 text-info"></i>Dashboard Operator
                                </a>
                            </li>
                        <?php endif; ?>
                        <li>
                            <form action="<?= site_url('logout') ?>" method="POST" class="m-0">
                                <?= csrf_field() ?>
                                <button type="submit" class="dropdown-item small py-2 text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="<?= site_url('login') ?>" class="btn btn-outline-cyber btn-sm px-3">
                    Login
                </a>
                <a href="<?= site_url('register') ?>" class="btn btn-cyber btn-sm px-3">
                    Daftar
                </a>
            <?php endif; ?>
        </div>
        </div>
    </div>
</nav>

<!-- Konten Utama -->
<main class="flex-grow-1">
    <?php if (!in_array($activeMenu ?? '', ['login', 'register'], true)): ?>
        <?php if (session()->getFlashdata('success') || session()->getFlashdata('error')): ?>
            <div class="container pt-4">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show small mb-0" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        <?= esc(session()->getFlashdata('success')) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show small mb-0" role="alert">
                        <i class="bi bi-shield-exclamation me-1"></i>
                        <?= esc(session()->getFlashdata('error')) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</main>

<!-- Footer -->
<footer class="footer-gaming py-5 mt-5">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4">
                <a class="navbar-brand brand-font fs-4 fw-bold d-inline-flex align-items-center gap-2 mb-2" href="<?= site_url('/') ?>">
                    <i class="bi bi-controller text-info"></i>
                    <span>Shop<span class="text-info">Ease</span></span>
                </a>
                <p class="text-secondary small mb-0">
                    Toko spesialis Gaming Gear & Desk Setup berperforma tinggi. 100% produk original bergaransi resmi dengan pengiriman aman ke seluruh Indonesia.
                </p>
            </div>
            <div class="col-6 col-lg-2 offset-lg-1">
                <h6 class="text-uppercase fw-bold small mb-3">Navigasi</h6>
                <ul class="list-unstyled small d-grid gap-2">
                    <li><a href="<?= site_url('/') ?>" class="text-secondary text-decoration-none">Beranda</a></li>
                    <li><a href="<?= site_url('catalog') ?>" class="text-secondary text-decoration-none">Katalog Produk</a></li>
                    <li><a href="<?= site_url('about') ?>" class="text-secondary text-decoration-none">Tentang Kami</a></li>
                    <li><a href="<?= site_url('contact') ?>" class="text-secondary text-decoration-none">Kontak</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h6 class="text-uppercase fw-bold small mb-3">Kategori</h6>
                <ul class="list-unstyled small d-grid gap-2">
                    <li><a href="<?= site_url('catalog?category=mechanical-keyboard') ?>" class="text-secondary text-decoration-none">Mechanical Keyboard</a></li>
                    <li><a href="<?= site_url('catalog?category=gaming-mouse') ?>" class="text-secondary text-decoration-none">Gaming Mouse</a></li>
                    <li><a href="<?= site_url('catalog?category=audio-headset') ?>" class="text-secondary text-decoration-none">Audio & Headset</a></li>
                    <li><a href="<?= site_url('catalog?category=desk-accessories') ?>" class="text-secondary text-decoration-none">Desk Accessories</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h6 class="text-uppercase fw-bold small mb-3">Layanan</h6>
                <p class="text-secondary small mb-2"><i class="bi bi-geo-alt text-info me-2"></i>Surabaya, Jawa Timur</p>
                <p class="text-secondary small mb-2"><i class="bi bi-clock text-info me-2"></i>Senin – Sabtu, 09:00 – 20:00 WIB</p>
                <p class="text-secondary small mb-0"><i class="bi bi-envelope text-info me-2"></i>support@shopease-gear.local</p>
            </div>
        </div>
        <hr class="border-secondary opacity-25 my-4">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center small text-secondary">
            <span>&copy; <?= date('Y') ?> ShopEase Gaming Gear. Project Web Framework CI4.</span>
            <span>Built with CodeIgniter 4 & Bootstrap 5</span>
        </div>
    </div>
</footer>

<!-- Modal Preview Fitur Tahap Selanjutnya -->
<div class="modal fade" id="comingSoonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title brand-font text-info">
                    <i class="bi bi-cpu me-2"></i>Modul Tahap Berikutnya
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-secondary">
                Fitur <strong class="text-white" id="featureNameLabel">ini</strong> akan diaktifkan pada tahap pengembangan selanjutnya setelah integrasi database MySQL.
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-cyber btn-sm px-4" data-bs-dismiss="modal">Mengerti</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const comingSoonModal = document.getElementById('comingSoonModal');
    if (comingSoonModal) {
        comingSoonModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const feature = button?.getAttribute('data-feature') || 'ini';
            document.getElementById('featureNameLabel').textContent = feature;
        });
    }
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>