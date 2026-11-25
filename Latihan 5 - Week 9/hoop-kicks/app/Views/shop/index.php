<?php
/**
 * @var array       $products
 * @var array       $categories
 * @var array|null  $spotlight
 * @var string|null $activeCategory
 * @var string|null $activeCourt
 * @var string      $keyword
 * @var string|null $sort
 * @var bool        $isFiltering
 */
?>
<?= $this->extend('layout/store') ?>

<?= $this->section('content') ?>

<?php if (! $isFiltering) : ?>
<!-- Editorial Asymmetric Hero -->
<section class="hk-hero">
    <div class="container-fluid px-0">
        <div class="row g-0">
            <div class="col-lg-7 p-4 p-md-5 d-flex flex-column justify-content-between border-end border-dark">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="hk-tag hk-tag-accent">DROP // 026</span>
                    <span class="font-mono small text-muted">ROTATION READY</span>
                </div>

                <div class="my-3 my-md-4">
                    <h1 class="font-display hk-hero-title mb-3">
                        LACE UP.<br>OWN THE<br><span style="color: var(--hk-accent);">HARDWOOD.</span>
                    </h1>
                    <p class="col-xl-8 text-muted mb-4">
                        Kurasi sepatu basket performa terbaik dari Nike, Adidas, Li-Ning, Jordan, hingga Under Armour. Pilih sesuai gaya main dan jenis lantai lapanganmu.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#catalog" class="hk-btn hk-btn-dark">Explore Rotation &darr;</a>
                        <a href="<?= base_url('/?court=Outdoor') ?>#catalog" class="hk-btn hk-btn-outline">Outdoor Spec</a>
                    </div>
                </div>

                <div class="row g-3 pt-4 mt-3 border-top border-dark-subtle font-mono small">
                    <div class="col-4">
                        <div class="fw-bold fs-5 text-dark"><?= count($products) ?>+</div>
                        <div class="text-muted">LIVE PAIRS</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold fs-5 text-dark">EU 40–46</div>
                        <div class="text-muted">SIZE RANGE</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold fs-5 text-dark">DOUBLE BOX</div>
                        <div class="text-muted">SAFE PACKING</div>
                    </div>
                </div>
            </div>

            <!-- Spotlight Card Kanan -->
            <div class="col-lg-5 hk-hero-panel p-4 p-md-5 d-flex flex-column justify-content-between">
                <?php if ($spotlight) : ?>
                    <div class="position-relative d-flex justify-content-between align-items-center">
                        <span class="hk-tag hk-tag-acid">FEATURED HEAT</span>
                        <span class="font-mono small text-white-50"><?= esc($spotlight['sku']) ?></span>
                    </div>

                    <div class="position-relative my-4">
                        <?php if (! empty($spotlight['image'])) : ?>
                            <div class="border border-light mb-3" style="aspect-ratio: 16/10; overflow: hidden;">
                                <img src="<?= base_url('uploads/products/' . $spotlight['image']) ?>" alt="<?= esc($spotlight['name']) ?>" class="w-100 h-100" style="object-fit: cover;">
                            </div>
                        <?php else : ?>
                            <div class="border border-secondary p-4 mb-3 text-center" style="background: rgba(255,255,255,0.03);">
                                <div class="font-mono small text-white-50 mb-1"><?= esc($spotlight['brand']) ?> &middot; <?= esc($spotlight['court_type']) ?></div>
                                <div class="font-display display-4 text-white fw-bold"><?= esc($spotlight['name']) ?></div>
                                <div class="font-mono small mt-2" style="color: var(--hk-acid);"><?= esc($spotlight['colorway']) ?></div>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between align-items-end">
                            <div>
                                <div class="font-mono small text-white-50"><?= esc($spotlight['category_name']) ?></div>
                                <h3 class="font-display fs-2 text-white mb-0"><?= esc($spotlight['name']) ?></h3>
                            </div>
                            <div class="font-mono fw-bold fs-5" style="color: var(--hk-acid);">
                                Rp <?= number_format($spotlight['price'], 0, ',', '.') ?>
                            </div>
                        </div>
                    </div>

                    <div class="position-relative">
                        <a href="<?= base_url('/product/' . $spotlight['slug']) ?>" class="hk-btn hk-btn-accent w-100">
                            Inspect Pair &amp; Select Size &rarr;
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Filter & Search Bar -->
<section id="catalog" class="container pt-5">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div>
            <div class="font-mono small text-muted text-uppercase">Footwear Catalog</div>
            <h2 class="font-display display-5 fw-bold mb-0">
                <?= $isFiltering ? 'HASIL PENCARIAN & FILTER' : 'ALL RELEASES' ?>
            </h2>
        </div>

        <form action="<?= base_url('/') ?>#catalog" method="get" class="d-flex flex-wrap gap-2">
            <?php if (! empty($activeCategory)) : ?>
                <input type="hidden" name="category" value="<?= esc($activeCategory) ?>">
            <?php endif; ?>
            <?php if (! empty($activeCourt)) : ?>
                <input type="hidden" name="court" value="<?= esc($activeCourt) ?>">
            <?php endif; ?>

            <input type="text" name="q" class="form-control" style="min-width: 220px;" value="<?= esc($keyword) ?>" placeholder="Cari Kobe, AE 1, Li-Ning...">

            <select name="sort" class="form-select" style="width: auto;" onchange="this.form.submit()">
                <option value="">Urutkan: Unggulan</option>
                <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Harga: Termurah</option>
                <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Harga: Termahal</option>
            </select>

            <button type="submit" class="hk-btn hk-btn-dark">Cari</button>
            <?php if ($isFiltering || ! empty($sort)) : ?>
                <a href="<?= base_url('/') ?>" class="hk-btn hk-btn-outline">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Category & Court Pills -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pb-4 mb-4 border-bottom border-dark">
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= base_url('/') ?>#catalog" class="hk-filter-pill <?= empty($activeCategory) ? 'active' : '' ?>">
                Semua Kategori
            </a>
            <?php foreach ($categories as $cat) : ?>
                <a href="<?= base_url('/?category=' . urlencode($cat['slug'])) ?>#catalog"
                   class="hk-filter-pill <?= $activeCategory === $cat['slug'] ? 'active' : '' ?>">
                    <?= esc($cat['name']) ?> (<?= $cat['product_count'] ?>)
                </a>
            <?php endforeach; ?>
        </div>

        <div class="d-flex flex-wrap gap-1">
            <?php foreach (['Indoor', 'Outdoor', 'All-Court'] as $ct) : ?>
                <a href="<?= base_url('/?court=' . urlencode($ct)) ?>#catalog"
                   class="hk-filter-pill <?= $activeCourt === $ct ? 'active' : '' ?>">
                    <?= $ct ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Product Grid -->
    <?php if (empty($products)) : ?>
        <div class="hk-card p-5 text-center">
            <div class="font-display fs-2 fw-bold mb-2">PAIR TIDAK DITEMUKAN</div>
            <p class="text-muted small mb-3">Coba kata kunci lain atau reset filter untuk melihat semua koleksi HoopKicks.</p>
            <a href="<?= base_url('/') ?>" class="hk-btn hk-btn-dark">Tampilkan Semua Produk</a>
        </div>
    <?php else : ?>
        <div class="row g-4">
            <?php foreach ($products as $p) : ?>
                <div class="col-sm-6 col-lg-3">
                    <div class="hk-card hk-product-card h-100 d-flex flex-column">
                        <a href="<?= base_url('/product/' . $p['slug']) ?>" class="hk-product-thumb d-block text-decoration-none">
                            <?php if (! empty($p['image'])) : ?>
                                <img src="<?= base_url('uploads/products/' . $p['image']) ?>" alt="<?= esc($p['name']) ?>">
                            <?php else : ?>
                                <div class="hk-placeholder-art">
                                    <span class="font-mono small text-muted"><?= esc($p['brand']) ?></span>
                                    <span class="font-display fs-3 fw-bold text-dark my-1"><?= esc($p['name']) ?></span>
                                    <span class="font-mono" style="font-size: 0.68rem; color: var(--hk-muted);"><?= esc($p['sku']) ?></span>
                                </div>
                            <?php endif; ?>

                            <div class="position-absolute top-0 start-0 p-2 d-flex gap-1">
                                <span class="hk-tag hk-tag-dark"><?= esc($p['court_type']) ?></span>
                                <?php if ((int) $p['stock'] <= 0) : ?>
                                    <span class="hk-tag hk-tag-accent">SOLD OUT</span>
                                <?php elseif ($p['is_featured']) : ?>
                                    <span class="hk-tag hk-tag-acid">HEAT</span>
                                <?php endif; ?>
                            </div>
                        </a>

                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <div class="d-flex justify-content-between font-mono text-muted mb-1" style="font-size: 0.7rem;">
                                <span><?= strtoupper(esc($p['brand'])) ?></span>
                                <span>STOK: <?= $p['stock'] ?></span>
                            </div>

                            <a href="<?= base_url('/product/' . $p['slug']) ?>" class="text-decoration-none text-dark">
                                <h5 class="fw-bold mb-1" style="font-size: 1.02rem;"><?= esc($p['name']) ?></h5>
                            </a>
                            <p class="small text-muted mb-3 flex-grow-1"><?= esc($p['colorway']) ?></p>

                            <div class="d-flex justify-content-between align-items-center pt-2 border-top border-dark-subtle">
                                <div class="font-mono fw-bold" style="font-size: 0.92rem;">
                                    Rp <?= number_format($p['price'], 0, ',', '.') ?>
                                </div>
                                <a href="<?= base_url('/product/' . $p['slug']) ?>" class="hk-btn hk-btn-dark hk-btn-sm">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
<?= $this->endSection() ?>