<?php /** @var array $product @var string $specsText @var array $categories @var array $images */ ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card-gaming p-4 p-md-5 mb-4">
                    <h3 class="fw-bold mb-4">Edit Produk</h3>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger small">
                            <ul class="mb-0 ps-3">
                                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                                    <li><?= esc($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('admin/products/update/' . $product['id_product']) ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="<?= esc(old('name', $product['name'])) ?>" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small text-secondary">Kategori <span class="text-danger">*</span></label>
                                <select name="id_category" class="form-select" required>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id_category'] ?>" <?= old('id_category', $product['id_category']) == $cat['id_category'] ? 'selected' : '' ?>>
                                            <?= esc($cat['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-secondary">Label / Badge</label>
                                <input type="text" name="badge" class="form-control" value="<?= esc(old('badge', $product['badge'])) ?>">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label small text-secondary">Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="price" class="form-control" min="0" step="1000" value="<?= esc(old('price', (int) $product['price'])) ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-secondary">Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stock" class="form-control" min="0" value="<?= esc(old('stock', $product['stock'])) ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-secondary">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select">
                                    <option value="tersedia" <?= old('status', $product['status']) === 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                    <option value="tidak_tersedia" <?= old('status', $product['status']) === 'tidak_tersedia' ? 'selected' : '' ?>>Tidak Tersedia</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3"><?= esc(old('description', $product['description'])) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-secondary">Spesifikasi (1 baris = <code>Label: Nilai</code>)</label>
                            <textarea name="specs_text" class="form-control" rows="4"><?= esc(old('specs_text', $specsText)) ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small text-secondary">Tambah Gambar Baru (Opsional)</label>
                            <input type="file" name="images[]" class="form-control" accept="image/jpeg,image/png,image/webp" multiple>
                            <small class="text-secondary">Format JPG, PNG, WEBP. Maks 2 MB per file.</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-cyber px-4">Update Produk</button>
                            <a href="<?= site_url('admin/products') ?>" class="btn btn-outline-secondary">Kembali</a>
                        </div>
                    </form>
                </div>

                <!-- Galeri Gambar Tersimpan -->
                <div class="card-gaming p-4">
                    <h5 class="fw-bold mb-3">Galeri Gambar Produk</h5>
                    <?php if (empty($images)): ?>
                        <p class="text-secondary small mb-0">Belum ada gambar terunggah untuk produk ini.</p>
                    <?php else: ?>
                        <div class="row g-3">
                            <?php foreach ($images as $img): ?>
                                <div class="col-6 col-md-4">
                                    <div class="p-2 rounded border border-secondary text-center" style="background: #0d1321;">
                                        <img src="<?= base_url('uploads/products/' . esc($img['image'])) ?>"
                                             alt="Foto Produk" class="img-fluid mb-2" style="height: 110px; object-fit: contain;">
                                        <div class="d-flex justify-content-center gap-1">
                                            <?php if ((int) $img['is_primary'] === 1): ?>
                                                <span class="badge bg-info text-dark">Utama</span>
                                            <?php else: ?>
                                                <form action="<?= site_url('admin/products/images/primary/' . $img['id_image']) ?>" method="POST">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-outline-info btn-sm py-0 px-2" style="font-size: 0.72rem;">Jadikan Utama</button>
                                                </form>
                                            <?php endif; ?>
                                            <form action="<?= site_url('admin/products/images/delete/' . $img['id_image']) ?>" method="POST" onsubmit="return confirm('Hapus gambar ini?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-outline-danger btn-sm py-0 px-2" style="font-size: 0.72rem;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>