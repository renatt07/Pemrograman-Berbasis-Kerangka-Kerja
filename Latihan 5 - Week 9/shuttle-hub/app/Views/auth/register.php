<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — ShuttleHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/shuttlehub.css') ?>" rel="stylesheet">
</head>
<body class="sh-hero d-flex align-items-center min-vh-100 py-4">
    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <a href="<?= base_url('/') ?>" class="sh-brand justify-content-center mb-2">
                        <span class="sh-logo-badge">
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
                    <p class="text-white-50 small mb-0">Buat akun member baru</p>
                </div>

                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Registrasi Pelanggan</h5>

                        <?php if (session()->getFlashdata('errors')) : ?>
                            <div class="alert alert-danger py-2 small">
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
                                <label for="name" class="form-label small fw-semibold">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?>" placeholder="Contoh: Budi Santoso" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label small fw-semibold">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" placeholder="nama@email.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label small fw-semibold">Nomor WhatsApp / HP</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?= old('phone') ?>" placeholder="0812xxxxxxxx" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label small fw-semibold">Kata Sandi</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Min. 6 karakter" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirm" class="form-label small fw-semibold">Ulangi Kata Sandi</label>
                                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Ulangi sandi" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">Daftar Sekarang</button>
                        </form>

                        <hr class="my-4">
                        <p class="text-center small text-muted mb-0">
                            Sudah punya akun? <a href="<?= base_url('/login') ?>" class="text-decoration-none fw-semibold" style="color: var(--sh-primary);">Masuk di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>