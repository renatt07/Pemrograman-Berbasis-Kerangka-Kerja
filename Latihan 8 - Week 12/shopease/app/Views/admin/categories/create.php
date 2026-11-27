<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card-gaming p-4 p-md-5">
                    <h3 class="fw-bold mb-4">Tambah Kategori Baru</h3>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger small">
                            <ul class="mb-0 ps-3">
                                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                                    <li><?= esc($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('admin/categories/store') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label small text-secondary">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="<?= esc(old('name')) ?>" placeholder="Contoh: Monitor Gaming" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-secondary">Bootstrap Icon (Opsional)</label>
                            <input type="text" name="icon" class="form-control" value="<?= esc(old('icon', 'bi-box-seam')) ?>" placeholder="Contoh: bi-keyboard, bi-mouse2, bi-headset">
                        </div>
                        <div class="mb-4">
                            <label class="form-label small text-secondary">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3"><?= esc(old('description')) ?></textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-cyber px-4">Simpan Kategori</button>
                            <a href="<?= site_url('admin/categories') ?>" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>