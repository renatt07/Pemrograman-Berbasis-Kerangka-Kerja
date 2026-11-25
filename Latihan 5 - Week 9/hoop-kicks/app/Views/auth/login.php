<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — HOOPKICKS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/hoopkicks.css') ?>" rel="stylesheet">
</head>
<body class="min-vh-100 d-flex flex-column">
    <div class="container-fluid flex-grow-1 p-0">
        <div class="row g-0 min-vh-100">
            <!-- Panel Kiri: Poster Editorial -->
            <div class="col-lg-6 hk-hero-panel d-none d-lg-flex flex-column justify-content-between p-5 border-end border-dark">
                <div class="position-relative">
                    <a href="<?= base_url('/') ?>" class="hk-brand text-white">HOOP<span>KICKS</span></a>
                    <div class="font-mono small text-white-50 mt-2">SURABAYA // BASKETBALL PERFORMANCE LAB</div>
                </div>

                <div class="position-relative my-auto py-5">
                    <span class="hk-tag hk-tag-acid mb-3">SEASON 26 DROP</span>
                    <h1 class="font-display display-1 fw-bold text-white mb-3">BUILT FOR<br>HARDWOOD<br>&amp; BLACKTOP.</h1>
                    <p class="text-white-50 col-xl-9 mb-0">
                        Kurasi sepatu basket performa tinggi—dari lini Signature indoor sampai outsole tahan gesekan lapangan outdoor.
                    </p>
                </div>

                <div class="position-relative font-mono small text-white-50 d-flex justify-content-between border-top border-secondary pt-3">
                    <span>100% AUTHENTIC PAIRS</span>
                    <span>EST. 2026</span>
                </div>
            </div>

            <!-- Panel Kanan: Form Login -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center p-4 p-md-5">
                <div class="w-100" style="max-width: 420px;">
                    <div class="d-lg-none mb-4">
                        <a href="<?= base_url('/') ?>" class="hk-brand">HOOP<span>KICKS</span></a>
                    </div>

                    <div class="font-mono small text-uppercase text-muted mb-1">Member Access</div>
                    <h2 class="font-display display-5 fw-bold mb-4">MASUK KE AKUN</h2>

                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success border border-dark small py-2"><?= esc(session()->getFlashdata('success')) ?></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger border border-dark small py-2"><?= esc(session()->getFlashdata('error')) ?></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger border border-dark small py-2">
                            <ul class="mb-0 ps-3">
                                <?php foreach (session()->getFlashdata('errors') as $err) : ?>
                                    <li><?= esc($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/login') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label font-mono small fw-bold text-uppercase">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= old('email') ?>" placeholder="nama@email.com" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label font-mono small fw-bold text-uppercase">Kata Sandi</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>

                        <button type="submit" class="hk-btn hk-btn-dark w-100 py-3">Masuk Sekarang &rarr;</button>
                    </form>

                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top border-dark-subtle small">
                        <span class="text-muted">Belum jadi member?</span>
                        <a href="<?= base_url('/register') ?>" class="font-mono fw-bold text-dark text-uppercase">Daftar Akun</a>
                    </div>
                    <div class="mt-3">
                        <a href="<?= base_url('/') ?>" class="font-mono small text-muted text-decoration-none">&larr; Kembali ke Katalog</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>