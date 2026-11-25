<?php
/**
 * @var array      $categories
 * @var array|null $product
 */
$isEdit = ! empty($product);
$action = $isEdit ? base_url('/admin/products/update/' . $product['id']) : base_url('/admin/products/store');
?>
<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <div class="font-mono small text-muted">PRODUCT EDITOR</div>
        <h1 class="font-display display-5 fw-bold mb-0"><?= $isEdit ? 'EDIT PRODUK' : 'TAMBAH PRODUK BARU' ?></h1>
    </div>
    <a href="<?= base_url('/admin/products') ?>" class="hk-btn hk-btn-outline hk-btn-sm">&larr; Kembali</a>
</div>

<div class="hk-card p-4">
    <form action="<?= $action ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label font-mono small fw-bold text-uppercase">SKU</label>
                <input type="text" name="sku" class="form-control font-mono" value="<?= old('sku', $product['sku'] ?? '') ?>" placeholder="NK-LB21-BLK" required>
            </div>
            <div class="col-md-5">
                <label class="form-label font-mono small fw-bold text-uppercase">Nama Sepatu / Produk</label>
                <input type="text" name="name" class="form-control" value="<?= old('name', $product['name'] ?? '') ?>" placeholder="Nike LeBron 21" required>
            </div>
            <div class="col-md-3">
                <label class="form-label font-mono small fw-bold text-uppercase">Brand</label>
                <input type="text" name="brand" class="form-control" value="<?= old('brand', $product['brand'] ?? '') ?>" placeholder="Nike / Adidas / Li-Ning" required>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label font-mono small fw-bold text-uppercase">Kategori</label>
                <?php $selCat = (int) old('category_id', $product['category_id'] ?? 0); ?>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($categories as $c) : ?>
                        <option value="<?= $c['id'] ?>" <?= $selCat === (int) $c['id'] ? 'selected' : '' ?>>
                            <?= esc($c['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label font-mono small fw-bold text-uppercase">Colorway</label>
                <input type="text" name="colorway" class="form-control" value="<?= old('colorway', $product['colorway'] ?? '') ?>" placeholder="Core Black / Solar Orange" required>
            </div>
            <div class="col-md-4">
                <label class="form-label font-mono small fw-bold text-uppercase">Tipe Lapangan</label>
                <?php $selCourt = old('court_type', $product['court_type'] ?? 'All-Court'); ?>
                <select name="court_type" class="form-select" required>
                    <option value="Indoor" <?= $selCourt === 'Indoor' ? 'selected' : '' ?>>Indoor</option>
                    <option value="Outdoor" <?= $selCourt === 'Outdoor' ? 'selected' : '' ?>>Outdoor</option>
                    <option value="All-Court" <?= $selCourt === 'All-Court' ? 'selected' : '' ?>>All-Court</option>
                </select>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label font-mono small fw-bold text-uppercase">Harga (Rp)</label>
                <input type="number" name="price" class="form-control font-mono" value="<?= old('price', $product['price'] ?? '') ?>" min="1000" step="1000" required>
            </div>
            <div class="col-md-3">
                <label class="form-label font-mono small fw-bold text-uppercase">Stok</label>
                <input type="number" name="stock" class="form-control font-mono" value="<?= old('stock', $product['stock'] ?? 10) ?>" min="0" required>
            </div>
            <div class="col-md-5">
                <label class="form-label font-mono small fw-bold text-uppercase">Pilihan Ukuran (pisah koma)</label>
                <input type="text" name="sizes" class="form-control font-mono" value="<?= old('sizes', $product['sizes'] ?? '40,41,42,43,44,45') ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label font-mono small fw-bold text-uppercase">Deskripsi Teknis</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan bantalan, traksi, dan karakter sepatu"><?= old('description', $product['description'] ?? '') ?></textarea>
        </div>

        <div class="row g-3 align-items-center mb-4">
            <div class="col-md-7">
                <label class="form-label font-mono small fw-bold text-uppercase">Foto Sepatu (JPG/PNG/WEBP, maks 2 MB)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <?php if ($isEdit && ! empty($product['image'])) : ?>
                    <div class="mt-2">
                        <img src="<?= base_url('uploads/products/' . $product['image']) ?>" alt="Preview" class="border border-dark" style="max-height: 110px;">
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-5">
                <div class="form-check mt-3">
                    <?php $featured = old('is_featured', $product['is_featured'] ?? 0); ?>
                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" <?= $featured ? 'checked' : '' ?>>
                    <label class="form-check-label font-mono small fw-bold" for="is_featured">
                        TANDAI SEBAGAI FEATURED HEAT (HERO)
                    </label>
                </div>
            </div>
        </div>

        <button type="submit" class="hk-btn hk-btn-accent px-4 py-2">
            <?= $isEdit ? 'Simpan Perubahan' : 'Publikasikan Produk' ?>
        </button>
    </form>
</div>
<?= $this->endSection() ?>