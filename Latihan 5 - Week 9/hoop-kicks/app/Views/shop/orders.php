<?php
/** @var array $orders */
?>
<?= $this->extend('layout/store') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <div class="font-mono small text-muted">MEMBER HISTORY</div>
            <h1 class="font-display display-4 fw-bold mb-0">PESANAN SAYA</h1>
        </div>
        <a href="<?= base_url('/') ?>" class="hk-btn hk-btn-dark hk-btn-sm">Belanja Lagi</a>
    </div>

    <?php if (empty($orders)) : ?>
        <div class="hk-card p-5 text-center">
            <div class="font-display fs-2 fw-bold mb-2">BELUM ADA PESANAN</div>
            <p class="text-muted small mb-4">Riwayat pembelian sepatu basket Anda akan tampil di sini.</p>
            <a href="<?= base_url('/') ?>" class="hk-btn hk-btn-accent">Mulai Belanja &rarr;</a>
        </div>
    <?php else : ?>
        <div class="d-flex flex-column gap-4">
            <?php foreach ($orders as $o) : ?>
                <?php
                    $statusTag = match ($o['status']) {
                        'paid'      => 'hk-tag-acid',
                        'shipped'   => 'hk-tag-dark',
                        'completed' => 'hk-tag-dark',
                        'cancelled' => 'hk-tag-accent',
                        default     => 'hk-tag-light',
                    };
                ?>
                <div class="hk-card">
                    <div class="p-3 bg-dark text-white d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div class="font-mono small">
                            <strong style="color: var(--hk-acid);"><?= esc($o['order_code']) ?></strong>
                            <span class="text-white-50 ms-2"><?= esc($o['created_at']) ?></span>
                        </div>
                        <span class="hk-tag <?= $statusTag ?>"><?= strtoupper(esc($o['status'])) ?></span>
                    </div>

                    <div class="p-4">
                        <div class="row g-3 mb-3 small">
                            <div class="col-md-4">
                                <div class="font-mono text-muted" style="font-size: 0.7rem;">PENERIMA</div>
                                <div class="fw-bold"><?= esc($o['recipient_name']) ?></div>
                                <div class="text-muted"><?= esc($o['phone']) ?></div>
                            </div>
                            <div class="col-md-5">
                                <div class="font-mono text-muted" style="font-size: 0.7rem;">ALAMAT PENGIRIMAN</div>
                                <div><?= esc($o['shipping_address']) ?></div>
                            </div>
                            <div class="col-md-3">
                                <div class="font-mono text-muted" style="font-size: 0.7rem;">PEMBAYARAN</div>
                                <div class="fw-semibold"><?= esc($o['payment_method']) ?></div>
                            </div>
                        </div>

                        <div class="border-top border-dark-subtle pt-3">
                            <?php foreach ($o['items'] as $it) : ?>
                                <div class="d-flex justify-content-between align-items-center py-1 small">
                                    <div>
                                        <span class="fw-bold"><?= esc($it['product_name']) ?></span>
                                        <span class="hk-tag hk-tag-light ms-1">Size <?= esc($it['shoe_size']) ?></span>
                                        <span class="font-mono text-muted ms-1">&times; <?= $it['quantity'] ?></span>
                                    </div>
                                    <div class="font-mono fw-semibold">Rp <?= number_format($it['subtotal'], 0, ',', '.') ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 mt-3 border-top border-dark">
                            <span class="font-mono small text-muted">TOTAL TRANSAKSI</span>
                            <span class="font-mono fs-5 fw-bold" style="color: var(--hk-accent);">
                                Rp <?= number_format($o['total_price'], 0, ',', '.') ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>