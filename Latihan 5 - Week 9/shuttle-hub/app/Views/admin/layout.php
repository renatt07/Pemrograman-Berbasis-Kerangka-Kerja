<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?= esc($title ?? 'Dashboard') ?> — Admin ShuttleHub</title>
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin@7.0.7/dist/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <style>
    .sb-topnav { background-color: #0A221F !important; border-bottom: 1px solid rgba(198, 241, 53, 0.2); }
    .sb-sidenav-dark { background-color: #0A221F; }
    .sb-sidenav-dark .sb-sidenav-footer { background-color: #071917; }
    .sb-sidenav-dark .sb-sidenav-menu .nav-link.active { color: #C6F135; }
    .sb-sidenav-dark .sb-sidenav-menu .nav-link.active .sb-nav-link-icon { color: #C6F135; }
    </style>

</head>
<body class="sb-nav-fixed">
    <!-- Top Navbar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3 fw-bold d-flex align-items-center gap-2" href="<?= base_url('/admin/dashboard') ?>">
            <span style="width:28px;height:28px;border-radius:7px;background:#C6F135;color:#0A221F;display:inline-flex;align-items:center;justify-content:center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <g transform="rotate(35 12 12)">
                        <path d="M9 17 L5 5 L9 7 L12 3.5 L15 7 L19 5 L15 17 Z" />
                        <path d="M10.5 17 L9 7 M13.5 17 L15 7 M12 17 L12 3.8 M7.7 13 H16.3" />
                        <path d="M9 17 h6 v1.5 a3 3 0 0 1 -6 0 Z" fill="currentColor" />
                    </g>
                </svg>
            </span>
            <span>Shuttle<span style="color:#C6F135;">Hub</span></span>
        </a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>

        <ul class="navbar-nav ms-auto me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw me-1"></i><?= esc(session()->get('name')) ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?= base_url('/') ?>">Lihat Halaman Publik</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item text-danger" href="<?= base_url('/logout') ?>">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <!-- Sidebar -->
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Utama</div>
                        <a class="nav-link <?= url_is('admin/dashboard*') ? 'active' : '' ?>" href="<?= base_url('/admin/dashboard') ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <div class="sb-sidenav-menu-heading">Manajemen GOR</div>
                        <a class="nav-link <?= url_is('admin/courts*') ? 'active' : '' ?>" href="<?= base_url('/admin/courts') ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-table-tennis-paddle-ball"></i></div>
                            Kelola Lapangan
                        </a>
                        <a class="nav-link <?= url_is('admin/bookings*') ? 'active' : '' ?>" href="<?= base_url('/admin/bookings') ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                            Kelola Booking
                        </a>

                        <div class="sb-sidenav-menu-heading">Lainnya</div>
                        <a class="nav-link" href="<?= base_url('/') ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-globe"></i></div>
                            Web Publik
                        </a>
                        <a class="nav-link text-danger" href="<?= base_url('/logout') ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-right-from-bracket text-danger"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Login sebagai:</div>
                    <?= esc(session()->get('name')) ?>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 py-4">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= esc(session()->getFlashdata('success')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= esc(session()->getFlashdata('error')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0 ps-3">
                                <?php foreach (session()->getFlashdata('errors') as $err) : ?>
                                    <li><?= esc($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?= $this->renderSection('content') ?>
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; ShuttleHub <?= date('Y') ?></div>
                        <div class="text-muted">Panel Admin — SBAdmin</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin@7.0.7/dist/js/scripts.js"></script>
</body>
</html>