<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="mb-4">
            <span class="text-info small fw-bold text-uppercase">Katalog Produk</span>
            <h1 class="fw-bold mb-1">Semua Gaming Gear</h1>
            <p class="text-secondary mb-0">Menampilkan <?= count($products) ?> produk pilihan.</p>
        </div>

        <!-- Bar Pencarian, Filter Kategori, & Sorting -->
        <form action="<?= site_url('catalog') ?>" method="GET" class="card-gaming p-3 p-md-4 mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small text-secondary">Cari Produk</label>
                    <input type="text" name="q" class="form-control" placeholder="Nama produk atau fitur..." value="<?= esc($keyword) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-secondary">Kategori</label>
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= esc($cat['slug']) ?>" <?= $selectedCat === $cat['slug'] ? 'selected' : '' ?>>
                                <?= esc($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-secondary">Urutkan</label>
                    <select name="sort" class="form-select">
                        <option value="">Default</option>
                        <option value="price_asc" <?= $selectedSort === 'price_asc' ? 'selected' : '' ?>>Harga Terendah</option>
                        <option value="price_desc" <?= $selectedSort === 'price_desc' ? 'selected' : '' ?>>Harga Tertinggi</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-cyber w-100">Terapkan</button>
                    <a href="<?= site_url('catalog') ?>" class="btn btn-outline-secondary" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </div>
        </form>

        <!-- Daftar Produk -->
        <?php if (empty($products)): ?>
            <div class="card-gaming p-5 text-center">
                <i class="bi bi-search fs-1 text-secondary mb-3 d-block"></i>
                <h4 class="fw-bold">Produk tidak ditemukan</h4>
                <p class="text-secondary mb-3">Coba kata kunci lain atau reset filter kategori.</p>
                <a href="<?= site_url('catalog') ?>" class="btn btn-outline-cyber">Reset Pencarian</a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($products as $p): ?>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card-gaming h-100 d-flex flex-column">
                            <div class="product-img-wrap">
                                <span class="product-badge <?= $p['stock'] === 0 ? 'border-secondary text-secondary' : '' ?>">
                                    <?= esc($p['badge']) ?>
                                </span>
                                <img src="<?= esc($p['image']) ?>" alt="<?= esc($p['name']) ?>">
                            </div>
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center small text-secondary mb-1">
                                    <span><?= esc($p['category_name']) ?></span>
                                    <?php if ($p['stock'] > 0): ?>
                                        <span class="text-success"><i class="bi bi-dot"></i>Stok <?= $p['stock'] ?></span>
                                    <?php else: ?>
                                        <span class="text-danger">Habis</span>
                                    <?php endif; ?>
                                </div>
                                <h6 class="fw-bold mb-2"><?= esc($p['name']) ?></h6>
                                <p class="text-secondary small mb-3">
                                    <?= esc(mb_strimwidth($p['description'], 0, 75, '...')) ?>
                                </p>
                                <div class="mt-auto">
                                    <div class="price-tag mb-3">Rp <?= number_format($p['price'], 0, ',', '.') ?></div>
                                    <div class="d-grid">
                                        <a href="<?= site_url('product/' . $p['id']) ?>" class="btn btn-outline-cyber btn-sm">
                                            Detail Produk
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>