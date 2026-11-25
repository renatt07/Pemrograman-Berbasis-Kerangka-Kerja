<?php
/**
 * @var int   $totalProducts
 * @var int   $totalCategories
 * @var int   $totalOrders
 * @var int   $pendingOrders
 * @var int   $totalRevenue
 * @var array $lowStockProducts
 * @var array $recentOrders
 */
?>
<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <div class="font-mono small text-muted">STORE OVERVIEW</div>
        <h1 class="font-display display-5 fw-bold mb-0">DASHBOARD ADMIN</h1>
    </div>
    <a href="<?= base_url('/admin/products/create') ?>" class="hk-btn hk-btn-accent hk-btn-sm">+ Tambah Produk</a>
</div>

<!-- Kartu Metrik -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="hk-card p-3 h-100">
            <div class="font-mono small text-muted">TOTAL PRODUK</div>
            <div class="font-display display-5 fw-bold my-1"><?= $totalProducts ?></div>
            <div class="font-mono small text-muted"><?= $totalCategories ?> kategori aktif</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="hk-card p-3 h-100" style="background: var(--hk-ink); color: #FFF;">
            <div class="font-mono small text-white-50">MENUNGGU PROSES</div>
            <div class="font-display display-5 fw-bold my-1" style="color: var(--hk-acid);"><?= $pendingOrders ?></div>
            <a href="<?= base_url('/admin/orders') ?>" class="font-mono small text-white text-decoration-none">Cek Pesanan &rarr;</a>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="hk-card p-3 h-100">
            <div class="font-mono small text-muted">TOTAL PESANAN</div>
            <div class="font-display display-5 fw-bold my-1"><?= $totalOrders ?></div>
            <div class="font-mono small text-muted">Semua transaksi</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="hk-card p-3 h-100" style="background: var(--hk-accent); color: #FFF;">
            <div class="font-mono small text-white-50">PENDAPATAN TERKONFIRMASI</div>
            <div class="font-mono fs-4 fw-bold my-2">Rp <?= number_format($totalRevenue, 0, ',', '.') ?></div>
            <div class="font-mono" style="font-size: 0.7rem;">PAID / SHIPPED / COMPLETED</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Pesanan Terbaru -->
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h4 class="font-display fs-3 fw-bold mb-0">PESANAN TERBARU</h4>
            <a href="<?= base_url('/admin/orders') ?>" class="font-mono small text-dark">Lihat Semua &rarr;</a>
        </div>
        <div class="table-responsive">
            <table class="table hk-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentOrders)) : ?>
                        <tr><td colspan="4" class="text-center text-muted py-4">Belum ada pesanan masuk.</td></tr>
                    <?php else : ?>
                        <?php foreach ($recentOrders as $o) : ?>
                            <tr>
                                <td class="font-mono small fw-bold"><?= esc($o['order_code']) ?></td>
                                <td>
                                    <div class="fw-semibold small"><?= esc($o['recipient_name']) ?></div>
                                    <div class="font-mono text-muted" style="font-size: 0.72rem;"><?= esc($o['payment_method']) ?></div>
                                </td>
                                <td class="font-mono small fw-bold">Rp <?= number_format($o['total_price'], 0, ',', '.') ?></td>
                                <td><span class="hk-tag hk-tag-dark"><?= strtoupper(esc($o['status'])) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Peringatan Stok Menipis -->
    <div class="col-lg-4">
        <h4 class="font-display fs-3 fw-bold mb-2">STOK MENIPIS (&le; 5)</h4>
        <div class="hk-card p-3">
            <?php if (empty($lowStockProducts)) : ?>
                <div class="font-mono small text-muted py-3 text-center">Semua stok produk aman.</div>
            <?php else : ?>
                <?php foreach ($lowStockProducts as $lp) : ?>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-dark-subtle small">
                        <div>
                            <div class="fw-bold"><?= esc($lp['name']) ?></div>
                            <div class="font-mono text-muted" style="font-size: 0.72rem;"><?= esc($lp['sku']) ?></div>
                        </div>
                        <a href="<?= base_url('/admin/products/edit/' . $lp['id']) ?>" class="hk-tag hk-tag-accent text-decoration-none">
                            SISA <?= $lp['stock'] ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>