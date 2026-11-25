<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Login — SIAKAD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/siakad.css') ?>" rel="stylesheet">
</head>
<body class="min-vh-100 d-flex flex-column bg-white">
    <div class="container-fluid flex-grow-1 p-0">
        <div class="row g-0 min-vh-100">
            <!-- Panel Kiri: Identitas Kampus -->
            <div class="col-lg-6 sk-login-visual text-white d-none d-lg-flex flex-column justify-content-between p-5">
                <div class="position-relative d-flex align-items-center gap-3">
                    <span class="sk-crest" style="width: 42px; height: 42px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.2);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 10L12 5 2 10l10 5 10-5z"/>
                            <path d="M6 12v5c0 1.7 2.7 3 6 3s6-1.3 6-3v-5"/>
                        </svg>
                    </span>
                    <div>
                        <div class="fw-bold fs-5 lh-1">SIAKAD</div>
                        <div class="small text-white-50">Sistem Informasi Akademik Terpadu</div>
                    </div>
                </div>

                <div class="position-relative my-auto py-5 col-xl-10">
                    <span class="badge rounded-pill mb-3 px-3 py-2" style="background: rgba(245, 158, 11, 0.18); color: #FCD34D; border: 1px solid rgba(245, 158, 11, 0.4);">
                        Semester Ganjil 2026/2027
                    </span>
                    <h1 class="display-5 fw-bold mb-3 lh-sm">Satu Portal untuk Seluruh Layanan Akademik.</h1>
                    <p class="text-white-50 mb-4">
                        Akses pengisian FRS, pemantauan kuota kelas, penilaian mahasiswa, perwalian dosen, hingga cetak transkrip resmi dalam satu tempat.
                    </p>

                    <div class="row g-3 pt-3 border-top border-white border-opacity-10 small">
                        <div class="col-4">
                            <div class="fw-bold text-white">Admin</div>
                            <div class="text-white-50">Master &amp; Kelas</div>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold text-white">Dosen</div>
                            <div class="text-white-50">Nilai &amp; Perwalian</div>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold text-white">Mahasiswa</div>
                            <div class="text-white-50">FRS, IPK &amp; Cetak</div>
                        </div>
                    </div>
                </div>

                <div class="position-relative small text-white-50 d-flex justify-content-between">
                    <span>Single Sign-On Akademik</span>
                    <span class="font-mono">v2.6</span>
                </div>
            </div>

            <!-- Panel Kanan: Form Login -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center p-4 p-md-5" style="background-color: var(--sk-bg);">
                <div class="w-100" style="max-width: 420px;">
                    <div class="d-lg-none d-flex align-items-center gap-2 mb-4">
                        <span class="sk-crest">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 10L12 5 2 10l10 5 10-5z"/>
                                <path d="M6 12v5c0 1.7 2.7 3 6 3s6-1.3 6-3v-5"/>
                            </svg>
                        </span>
                        <span class="fw-bold fs-4 text-dark">SIAKAD<span style="color: var(--sk-indigo);">.</span></span>
                    </div>

                    <div class="card p-4 p-md-5">
                        <div class="font-mono small fw-semibold text-uppercase mb-1" style="color: var(--sk-indigo); font-size: 0.72rem;">
                            Academic Sign In
                        </div>
                        <h3 class="fw-bold mb-1">Masuk ke Portal</h3>
                        <p class="text-muted small mb-4">Gunakan akun Admin, Dosen, atau Mahasiswa Anda.</p>

                        <?php if (session()->getFlashdata('success')) : ?>
                            <div class="alert alert-success border-0 py-2 small"><?= esc(session()->getFlashdata('success')) ?></div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger border-0 py-2 small"><?= esc(session()->getFlashdata('error')) ?></div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('errors')) : ?>
                            <div class="alert alert-danger border-0 py-2 small">
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
                                <label for="email" class="form-label small fw-semibold">Email Akademik</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" placeholder="nama@siakad.test" required>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label small fw-semibold">Kata Sandi</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan kata sandi" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2">
                                Masuk ke SIAKAD <i class="bi bi-arrow-right-short"></i>
                            </button>
                        </form>
                    </div>

                    <div class="text-center small text-muted mt-4">
                        &copy; <?= date('Y') ?> SIAKAD &middot; CodeIgniter 4
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>