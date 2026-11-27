<?php /** @var int $processingCount @var int $shippedCount @var int $lowStockCount @var array $readyToShip */ ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 mb-2">ROLE: OPERATOR TOKO</span>
                <h1 class="fw-bold mb-0">Dashboard Operasional</h1>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= site_url('admin/orders') ?>" class="btn btn-cyber btn-sm px-3"><i class="bi bi-truck me-1"></i> Kelola Pengiriman</a>
                <a href="<?= site_url('admin/products') ?>" class="btn btn-outline-cyber btn-sm px-3"><i class="bi bi-box-seam me-1"></i> Kelola Stok</a>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card-gaming p-4">
                    <div class="small text-secondary">Siap Dikemas / Kirim</div>
                    <div class="brand-font fs-2 fw-bold text-info"><?= $processingCount ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-gaming p-4">
                    <div class="small text-secondary">Sedang Dalam Pengiriman</div>
                    <div class="brand-font fs-2 fw-bold text-white"><?= $shippedCount ?></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-gaming p-4">
                    <div class="small text-secondary">Produk Stok Menipis (&le; 5)</div>
                    <div class="brand-font fs-2 fw-bold text-warning"><?= $lowStockCount ?></div>
                </div>
            </div>
        </div>

        <div class="card-gaming p-4">
            <h5 class="fw-bold text-info mb-3">Antrean Pengiriman Pesanan</h5>
            <div class="table-responsive">
                <table class="table table-dark table-sm align-middle mb-0">
                    <thead>
                        <tr class="text-secondary small">
                            <th>No. Order</th><th>Customer</th><th>Status</th><th>Kurir / Resi</th><th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($readyToShip as $o): ?>
                            <tr>
                                <td class="text-info fw-semibold"><?= esc($o['order_number']) ?></td>
                                <td><?= esc($o['customer_name']) ?></td>
                                <td><span class="badge bg-info bg-opacity-25 text-info"><?= esc(strtoupper($o['order_status'])) ?></span></td>
                                <td class="small text-secondary"><?= esc($o['courier'] ? $o['courier'] . ' — ' . $o['tracking_number'] : 'Belum diinput') ?></td>
                                <td class="text-end"><a href="<?= site_url('admin/orders/' . $o['id_order']) ?>" class="btn btn-outline-cyber btn-sm py-0">Input Resi</a></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($readyToShip)): ?>
                            <tr><td colspan="5" class="text-center text-secondary py-3">Tidak ada pesanan menunggu pengiriman.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>