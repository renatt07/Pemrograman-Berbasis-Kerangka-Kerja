<?php /** @var array $categories */ ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card-gaming p-4 p-md-5">
                    <h3 class="fw-bold mb-4">Tambah Produk Baru</h3>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger small">
                            <ul class="mb-0 ps-3">
                                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                                    <li><?= esc($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('admin/products/store') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="<?= esc(old('name')) ?>" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small text-secondary">Kategori <span class="text-danger">*</span></label>
                                <select name="id_category" class="form-select" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id_category'] ?>" <?= old('id_category') == $cat['id_category'] ? 'selected' : '' ?>>
                                            <?= esc($cat['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-secondary">Label / Badge (Opsional)</label>
                                <input type="text" name="badge" class="form-control" value="<?= esc(old('badge')) ?>" placeholder="Contoh: Best Seller, Pro Choice, New">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label small text-secondary">Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="price" class="form-control" min="0" step="1000" value="<?= esc(old('price')) ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-secondary">Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stock" class="form-control" min="0" value="<?= esc(old('stock', 10)) ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-secondary">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select">
                                    <option value="tersedia" <?= old('status') === 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                    <option value="tidak_tersedia" <?= old('status') === 'tidak_tersedia' ? 'selected' : '' ?>>Tidak Tersedia</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3"><?= esc(old('description')) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">Spesifikasi (1 baris = <code>Label: Nilai</code>)</label>
                            <textarea name="specs_text" class="form-control" rows="4" placeholder="Sensor: PixArt PAW3395&#10;Bobot: 52 gram&#10;Konektivitas: 2.4GHz Wireless"><?= esc(old('specs_text')) ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small text-secondary">Foto Produk (Bisa pilih lebih dari 1)</label>
                            <input type="file" name="images[]" class="form-control" accept="image/jpeg,image/png,image/webp" multiple>
                            <small class="text-secondary">Format JPG, PNG, atau WEBP. Maksimal 2 MB per gambar.</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-cyber px-4">Simpan Produk</button>
                            <a href="<?= site_url('admin/products') ?>" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>