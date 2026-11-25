<?php
/**
 * @var array $product
 * @var array $sizes
 * @var array $related
 */
?>
<?= $this->extend('layout/store') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="mb-4">
        <a href="<?= base_url('/') ?>" class="font-mono small text-dark text-decoration-none">&larr; KEMBALI KE KATALOG</a>
    </div>

    <div class="hk-card">
        <div class="row g-0">
            <!-- Kiri: Foto / Art -->
            <div class="col-lg-6 border-end border-dark" style="background-color: #ECEAE2;">
                <?php if (! empty($product['image'])) : ?>
                    <img src="<?= base_url('uploads/products/' . $product['image']) ?>" alt="<?= esc($product['name']) ?>" class="w-100 h-100" style="min-height: 420px; max-height: 560px; object-fit: cover;">
                <?php else : ?>
                    <div class="hk-placeholder-art" style="min-height: 420px;">
                        <span class="hk-tag hk-tag-dark mb-2"><?= esc($product['brand']) ?></span>
                        <div class="font-display display-4 fw-bold text-dark"><?= esc($product['name']) ?></div>
                        <div class="font-mono small text-muted mt-2"><?= esc($product['colorway']) ?></div>
                        <div class="font-mono small text-muted mt-1">SKU: <?= esc($product['sku']) ?></div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Kanan: Spec & Add to Bag -->
            <div class="col-lg-6 p-4 p-md-5 d-flex flex-column">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="hk-tag hk-tag-light"><?= esc($product['category_name']) ?></span>
                    <span class="hk-tag hk-tag-dark"><?= esc($product['court_type']) ?> SPEC</span>
                    <span class="font-mono small text-muted ms-auto">SKU: <?= esc($product['sku']) ?></span>
                </div>

                <div class="font-mono small fw-bold text-uppercase" style="color: var(--hk-accent);"><?= esc($product['brand']) ?></div>
                <h1 class="font-display display-4 fw-bold mb-1"><?= esc($product['name']) ?></h1>
                <div class="text-muted small mb-3"><?= esc($product['colorway']) ?></div>

                <div class="font-mono fs-3 fw-bold pb-3 mb-3 border-bottom border-dark">
                    Rp <?= number_format($product['price'], 0, ',', '.') ?>
                </div>

                <p class="text-muted mb-4"><?= esc($product['description']) ?></p>

                <?php if ((int) $product['stock'] > 0) : ?>
                    <form action="<?= base_url('/cart/add') ?>" method="post" class="mt-auto">
                        <?= csrf_field() ?>
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="font-mono small fw-bold text-uppercase">Pilih Ukuran (EU / Size)</label>
                                <span class="font-mono small text-muted">Stok Tersedia: <strong><?= $product['stock'] ?></strong></span>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ($sizes as $idx => $sz) : ?>
                                    <div>
                                        <input type="radio" class="hk-size-input" name="shoe_size" id="size_<?= esc($sz) ?>" value="<?= esc($sz) ?>" <?= $idx === 0 ? 'checked' : '' ?> required>
                                        <label class="hk-size-label" for="size_<?= esc($sz) ?>"><?= esc($sz) ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="row g-2 align-items-end mt-4">
                            <div class="col-4 col-sm-3">
                                <label class="font-mono small fw-bold text-uppercase mb-1">Qty</label>
                                <input type="number" name="quantity" class="form-control text-center font-mono fw-bold" value="1" min="1" max="<?= $product['stock'] ?>" required>
                            </div>
                            <div class="col-8 col-sm-9">
                                <button type="submit" class="hk-btn hk-btn-accent w-100 py-3">
                                    <i class="bi bi-bag-plus"></i> Add To Bag
                                </button>
                            </div>
                        </div>
                    </form>
                <?php else : ?>
                    <div class="alert alert-dark font-mono small fw-bold text-center mt-auto mb-0">
                        STOK HABIS — TUNGGU RESTOCK BERIKUTNYA
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (! empty($related)) : ?>
        <div class="mt-5 pt-4">
            <h3 class="font-display fs-2 fw-bold mb-3">OTHER PAIRS IN <?= strtoupper(esc($product['category_name'])) ?></h3>
            <div class="row g-4">
                <?php foreach ($related as $r) : ?>
                    <div class="col-sm-6 col-lg-3">
                        <a href="<?= base_url('/product/' . $r['slug']) ?>" class="hk-card hk-product-card d-block text-decoration-none text-dark h-100">
                            <div class="p-3">
                                <div class="font-mono small text-muted"><?= esc($r['brand']) ?> &middot; <?= esc($r['court_type']) ?></div>
                                <div class="fw-bold my-1"><?= esc($r['name']) ?></div>
                                <div class="font-mono fw-bold small" style="color: var(--hk-accent);">
                                    Rp <?= number_format($r['price'], 0, ',', '.') ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>