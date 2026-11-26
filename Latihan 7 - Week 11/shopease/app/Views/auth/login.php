<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container py-lg-4">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="card-gaming p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="category-icon mx-auto mb-3">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <h2 class="fw-bold mb-1">Login ShopEase</h2>
                        <p class="text-secondary small mb-0">Masuk ke akun Gaming Gear Anda</p>
                    </div>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success small">
                            <i class="bi bi-check-circle me-1"></i>
                            <?= esc(session()->getFlashdata('success')) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger small">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            <?= esc(session()->getFlashdata('error')) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger small">
                            <ul class="mb-0 ps-3">
                                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                                    <li><?= esc($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('login') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="<?= esc(old('email')) ?>"
                                   placeholder="nama@email.com" required autofocus>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small text-secondary">Password</label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="Masukkan password" required>
                        </div>

                        <button type="submit" class="btn btn-cyber w-100 py-2">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </button>
                    </form>

                    <hr class="border-secondary opacity-25 my-4">
                    <p class="text-center text-secondary small mb-0">
                        Belum memiliki akun?
                        <a href="<?= site_url('register') ?>" class="text-info text-decoration-none fw-semibold">
                            Daftar di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>