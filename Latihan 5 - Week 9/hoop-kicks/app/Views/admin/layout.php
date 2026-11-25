<?php
/** @var string|null $title */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin') ?> — HOOPKICKS LAB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/hoopkicks.css') ?>" rel="stylesheet">
    <style>
        .hk-admin-shell {
            display: flex;
            min-height: 100vh;
        }
        .hk-sidebar {
            width: 250px;
            flex-shrink: 0;
            background-color: var(--hk-ink);
            color: #FFFFFF;
            border-right: 1.5px solid var(--hk-border);
            display: flex;
            flex-direction: column;
        }
        .hk-side-link {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.85rem 1.25rem;
            color: #C4C4CC;
            text-decoration: none;
            font-family: var(--font-mono);
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            transition: background-color 0.12s ease, color 0.12s ease;
        }
        .hk-side-link:hover {
            background-color: rgba(255, 255, 255, 0.06);
            color: #FFFFFF;
        }
        .hk-side-link.active {
            background-color: var(--hk-accent);
            color: #FFFFFF;
            font-weight: 700;
        }
        @media (max-width: 991.98px) {
            .hk-admin-shell { flex-direction: column; }
            .hk-sidebar { width: 100%; border-right: 0; border-bottom: 1.5px solid var(--hk-border); }
        }
    </style>
</head>
<body>
    <div class="hk-admin-shell">
        <!-- Sidebar Editorial -->
        <aside class="hk-sidebar">
            <div class="p-4 border-bottom border-secondary">
                <a href="<?= base_url('/admin/dashboard') ?>" class="hk-brand text-white">HOOP<span>KICKS</span></a>
                <div class="font-mono mt-1" style="font-size: 0.68rem; color: var(--hk-acid);">ADMIN CONTROL LAB</div>
            </div>

            <nav class="flex-grow-1">
                <a href="<?= base_url('/admin/dashboard') ?>" class="hk-side-link <?= url_is('admin/dashboard*') ? 'active' : '' ?>">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>
                <a href="<?= base_url('/admin/products') ?>" class="hk-side-link <?= url_is('admin/products*') ? 'active' : '' ?>">
                    <i class="bi bi-box-seam-fill"></i> Produk Sepatu
                </a>
                <a href="<?= base_url('/admin/categories') ?>" class="hk-side-link <?= url_is('admin/categories*') ? 'active' : '' ?>">
                    <i class="bi bi-tags-fill"></i> Kategori
                </a>
                <a href="<?= base_url('/admin/orders') ?>" class="hk-side-link <?= url_is('admin/orders*') ? 'active' : '' ?>">
                    <i class="bi bi-receipt-cutoff"></i> Pesanan Masuk
                </a>
                <a href="<?= base_url('/') ?>" class="hk-side-link">
                    <i class="bi bi-shop"></i> Lihat Storefront
                </a>
            </nav>

            <div class="p-3 border-top border-secondary">
                <div class="font-mono small text-white-50 mb-2"><?= esc(session()->get('name')) ?></div>
                <a href="<?= base_url('/logout') ?>" class="hk-btn hk-btn-accent hk-btn-sm w-100">Logout</a>
            </div>
        </aside>

        <!-- Konten Utama Admin -->
        <div class="flex-grow-1 d-flex flex-column">
            <header class="bg-white border-bottom border-dark px-4 py-3 d-flex justify-content-between align-items-center">
                <span class="font-mono small text-uppercase text-muted">HOOPKICKS // <?= esc($title ?? 'ADMIN') ?></span>
                <span class="hk-tag hk-tag-acid">ONLINE</span>
            </header>

            <main class="p-4 flex-grow-1">
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success border border-dark d-flex justify-content-between align-items-center py-2 mb-4">
                        <span class="small fw-semibold"><?= esc(session()->getFlashdata('success')) ?></span>
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger border border-dark d-flex justify-content-between align-items-center py-2 mb-4">
                        <span class="small fw-semibold"><?= esc(session()->getFlashdata('error')) ?></span>
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger border border-dark py-2 mb-4 small">
                        <ul class="mb-0 ps-3">
                            <?php foreach (session()->getFlashdata('errors') as $err) : ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>