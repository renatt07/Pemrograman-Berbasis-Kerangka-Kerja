<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container py-lg-3">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card-gaming p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="category-icon mx-auto mb-3">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <h2 class="fw-bold mb-1">Buat Akun Baru</h2>
                        <p class="text-secondary small mb-0">Bergabung dengan ShopEase Gaming Gear</p>
                    </div>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger small">
                            <ul class="mb-0 ps-3">
                                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                                    <li><?= esc($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('register') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control"
                                   value="<?= esc(old('name')) ?>"
                                   placeholder="Minimal 3 karakter" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small text-secondary">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control"
                                       value="<?= esc(old('email')) ?>"
                                       placeholder="nama@email.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-secondary">Nomor Telepon</label>
                                <input type="text" name="phone" class="form-control"
                                       value="<?= esc(old('phone')) ?>"
                                       placeholder="08xxxxxxxxxx">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">Alamat</label>
                            <textarea name="address" class="form-control" rows="2"
                                      placeholder="Alamat pengiriman (opsional)"><?= esc(old('address')) ?></textarea>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small text-secondary">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control"
                                       placeholder="Minimal 8 karakter" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-secondary">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirm" class="form-control"
                                       placeholder="Ulangi password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-cyber w-100 py-2">
                            <i class="bi bi-check2-circle me-1"></i> Daftar Sekarang
                        </button>
                    </form>

                    <hr class="border-secondary opacity-25 my-4">
                    <p class="text-center text-secondary small mb-0">
                        Sudah memiliki akun?
                        <a href="<?= site_url('login') ?>" class="text-info text-decoration-none fw-semibold">
                            Login di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>