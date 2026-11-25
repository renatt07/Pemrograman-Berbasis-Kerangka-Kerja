<?php
/**
 * @var array $items
 * @var int   $total
 */
?>
<?= $this->extend('layout/store') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <div class="font-mono small text-muted">YOUR ROTATION</div>
            <h1 class="font-display display-4 fw-bold mb-0">SHOPPING BAG</h1>
        </div>
        <a href="<?= base_url('/') ?>" class="hk-btn hk-btn-outline hk-btn-sm">&larr; Lanjut Belanja</a>
    </div>

    <?php if (empty($items)) : ?>
        <div class="hk-card p-5 text-center">
            <div class="font-display fs-2 fw-bold mb-2">KERANJANG MASIH KOSONG</div>
            <p class="text-muted small mb-4">Belum ada sepatu yang dimasukkan. Cek rilisan terbaru HoopKicks sekarang.</p>
            <a href="<?= base_url('/') ?>" class="hk-btn hk-btn-dark">Lihat Katalog &rarr;</a>
        </div>
    <?php else : ?>
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="table-responsive">
                    <table class="table hk-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Size</th>
                                <th>Harga</th>
                                <th style="width: 145px;">Qty</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item) : ?>
                                <tr>
                                    <td>
                                        <a href="<?= base_url('/product/' . $item['slug']) ?>" class="fw-bold text-dark text-decoration-none">
                                            <?= esc($item['name']) ?>
                                        </a>
                                        <div class="font-mono text-muted" style="font-size: 0.72rem;">
                                            <?= esc($item['brand']) ?> &middot; <?= esc($item['sku']) ?>
                                        </div>
                                    </td>
                                    <td><span class="hk-tag hk-tag-dark"><?= esc($item['shoe_size']) ?></span></td>
                                    <td class="font-mono small">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                    <td>
                                        <form action="<?= base_url('/cart/update') ?>" method="post" class="d-flex gap-1">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="key" value="<?= esc($item['key']) ?>">
                                            <input type="number" name="quantity" class="form-control form-control-sm text-center font-mono" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>">
                                            <button type="submit" class="hk-btn hk-btn-outline hk-btn-sm px-2">OK</button>
                                        </form>
                                    </td>
                                    <td class="font-mono fw-bold small">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                    <td>
                                        <form action="<?= base_url('/cart/remove/' . urlencode($item['key'])) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Hapus">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="hk-card p-4">
                    <div class="font-mono small text-muted text-uppercase mb-1">Order Summary</div>
                    <h4 class="font-display fs-2 fw-bold pb-3 mb-3 border-bottom border-dark">RINGKASAN</h4>

                    <div class="d-flex justify-content-between small mb-2">
                        <span class="text-muted">Total Item</span>
                        <span class="font-mono fw-bold"><?= array_sum(array_column($items, 'quantity')) ?> pasang</span>
                    </div>
                    <div class="d-flex justify-content-between small mb-3">
                        <span class="text-muted">Pengiriman (Double Box)</span>
                        <span class="font-mono fw-bold text-success">GRATIS</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 mb-4 border-top border-dark">
                        <span class="font-mono small fw-bold">TOTAL BAYAR</span>
                        <span class="font-mono fs-5 fw-bold" style="color: var(--hk-accent);">
                            Rp <?= number_format($total, 0, ',', '.') ?>
                        </span>
                    </div>

                    <a href="<?= base_url('/checkout') ?>" class="hk-btn hk-btn-accent w-100 py-3">
                        Lanjut ke Checkout &rarr;
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>