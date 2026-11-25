<?php
/** @var string|null $title */
$role      = session()->get('role');
$roleClass = match ($role) {
    'admin'     => 'sk-role-admin',
    'dosen'     => 'sk-role-dosen',
    default     => 'sk-role-mahasiswa',
};
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard') ?> — SIAKAD</title>
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin@7.0.7/dist/css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/siakad.css') ?>" rel="stylesheet">
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-light">
        <a class="navbar-brand ps-3 d-flex align-items-center gap-2" href="<?= base_url('/') ?>">
            <span class="sk-crest">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10L12 5 2 10l10 5 10-5z"/>
                    <path d="M6 12v5c0 1.7 2.7 3 6 3s6-1.3 6-3v-5"/>
                </svg>
            </span>
            <span>SIAKAD<span style="color: var(--sk-indigo);">.</span></span>
        </a>

        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 sk-toggle-btn" id="sidebarToggle">
            <i class="bi bi-list fs-5"></i>
        </button>

        <div class="ms-auto me-3 d-flex align-items-center gap-3">
            <span class="sk-role-pill <?= $roleClass ?>"><?= esc($role) ?></span>
            <div class="d-none d-md-flex align-items-center gap-2">
                <span class="small fw-semibold text-dark"><?= esc(session()->get('name')) ?></span>
            </div>
            <a href="<?= base_url('/logout') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-box-arrow-right me-1"></i>Keluar
            </a>
        </div>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <?php if ($role === 'admin') : ?>
                            <div class="sb-sidenav-menu-heading">Administrator</div>
                            <a class="nav-link <?= url_is('admin/dashboard*') ? 'active' : '' ?>" href="<?= base_url('/admin/dashboard') ?>">
                                <i class="bi bi-grid-1x2 me-2"></i>Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Data Master</div>
                            <a class="nav-link <?= url_is('admin/prodi*') ? 'active' : '' ?>" href="<?= base_url('/admin/prodi') ?>">
                                <i class="bi bi-building me-2"></i>Program Studi
                            </a>
                            <a class="nav-link <?= url_is('admin/dosen*') ? 'active' : '' ?>" href="<?= base_url('/admin/dosen') ?>">
                                <i class="bi bi-person-badge me-2"></i>Data Dosen
                            </a>
                            <a class="nav-link <?= url_is('admin/mahasiswa*') ? 'active' : '' ?>" href="<?= base_url('/admin/mahasiswa') ?>">
                                <i class="bi bi-people me-2"></i>Data Mahasiswa
                            </a>
                            <a class="nav-link <?= url_is('admin/matakuliah*') ? 'active' : '' ?>" href="<?= base_url('/admin/matakuliah') ?>">
                                <i class="bi bi-journal-bookmark me-2"></i>Mata Kuliah
                            </a>
                            <a class="nav-link <?= url_is('admin/kelas*') ? 'active' : '' ?>" href="<?= base_url('/admin/kelas') ?>">
                                <i class="bi bi-easel me-2"></i>Kelola Kelas
                            </a>

                        <?php elseif ($role === 'dosen') : ?>
                            <div class="sb-sidenav-menu-heading">Portal Dosen</div>
                            <a class="nav-link <?= url_is('dosen/dashboard*') ? 'active' : '' ?>" href="<?= base_url('/dosen/dashboard') ?>">
                                <i class="bi bi-grid-1x2 me-2"></i>Dashboard
                            </a>
                            <a class="nav-link <?= url_is('dosen/kelas*') ? 'active' : '' ?>" href="<?= base_url('/dosen/kelas') ?>">
                                <i class="bi bi-easel me-2"></i>Kelas Diampu &amp; Nilai
                            </a>
                            <a class="nav-link <?= url_is('dosen/perwalian*') ? 'active' : '' ?>" href="<?= base_url('/dosen/perwalian') ?>">
                                <i class="bi bi-people me-2"></i>Mahasiswa Perwalian
                            </a>

                        <?php elseif ($role === 'mahasiswa') : ?>
                            <div class="sb-sidenav-menu-heading">Portal Mahasiswa</div>
                            <a class="nav-link <?= url_is('mahasiswa/dashboard*') ? 'active' : '' ?>" href="<?= base_url('/mahasiswa/dashboard') ?>">
                                <i class="bi bi-grid-1x2 me-2"></i>Dashboard &amp; Profil
                            </a>
                            <a class="nav-link <?= url_is('mahasiswa/frs*') ? 'active' : '' ?>" href="<?= base_url('/mahasiswa/frs') ?>">
                                <i class="bi bi-card-checklist me-2"></i>Pengisian FRS
                            </a>
                            <a class="nav-link <?= url_is('mahasiswa/nilai*') ? 'active' : '' ?>" href="<?= base_url('/mahasiswa/nilai') ?>">
                                <i class="bi bi-award me-2"></i>Nilai &amp; IPK
                            </a>
                            <a class="nav-link <?= url_is('mahasiswa/cetak*') ? 'active' : '' ?>" href="<?= base_url('/mahasiswa/cetak/transkrip') ?>" target="_blank">
                                <i class="bi bi-printer me-2"></i>Cetak Transkrip
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small text-white-50">Sesi Aktif</div>
                    <div class="fw-semibold text-white text-truncate"><?= esc(session()->get('name')) ?></div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 py-4">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show">
                            <i class="bi bi-check-circle-fill me-2"></i><?= esc(session()->getFlashdata('success')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= esc(session()->getFlashdata('error')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show">
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

            <footer class="py-3 bg-white mt-auto border-top">
                <div class="container-fluid px-4 small text-muted d-flex justify-content-between">
                    <span>&copy; <?= date('Y') ?> SIAKAD — Sistem Informasi Akademik Terpadu</span>
                    <span class="font-mono" style="font-size: 0.75rem;">TA 2026/2027</span>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin@7.0.7/dist/js/scripts.js"></script>
</body>
</html>