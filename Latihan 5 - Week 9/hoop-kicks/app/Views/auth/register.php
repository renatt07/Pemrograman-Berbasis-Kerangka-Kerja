<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — HOOPKICKS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/hoopkicks.css') ?>" rel="stylesheet">
</head>
<body class="min-vh-100 d-flex align-items-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="d-flex justify-content-between align-items-end mb-3">
                    <a href="<?= base_url('/') ?>" class="hk-brand">HOOP<span>KICKS</span></a>
                    <span class="hk-tag hk-tag-dark">NEW MEMBER</span>
                </div>

                <div class="hk-card p-4 p-md-5">
                    <h2 class="font-display display-6 fw-bold mb-1">BUAT AKUN BARU</h2>
                    <p class="text-muted small mb-4">Simpan alamat pengiriman dan pantau riwayat pesanan sepatu Anda.</p>

                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger border border-dark small py-2">
                            <ul class="mb-0 ps-3">
                                <?php foreach (session()->getFlashdata('errors') as $err) : ?>
                                    <li><?= esc($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/register') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label font-mono small fw-bold text-uppercase">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="<?= old('name') ?>" required>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label font-mono small fw-bold text-uppercase">Email</label>
                                <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-mono small fw-bold text-uppercase">No. HP / WA</label>
                                <input type="text" name="phone" class="form-control" value="<?= old('phone') ?>" placeholder="0812xxxxxxxx" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label font-mono small fw-bold text-uppercase">Alamat Pengiriman</label>
                            <textarea name="address" class="form-control" rows="2" required><?= old('address') ?></textarea>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label font-mono small fw-bold text-uppercase">Kata Sandi</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-mono small fw-bold text-uppercase">Ulangi Sandi</label>
                                <input type="password" name="password_confirm" class="form-control" required>
                            </div>
                        </div>

                        <button type="submit" class="hk-btn hk-btn-accent w-100 py-3">Daftar Member &rarr;</button>
                    </form>

                    <div class="text-center mt-4 small">
                        Sudah punya akun? <a href="<?= base_url('/login') ?>" class="font-mono fw-bold text-dark">MASUK DI SINI</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>