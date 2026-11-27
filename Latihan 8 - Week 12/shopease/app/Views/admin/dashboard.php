<?php /** @var int $totalProducts @var int $totalCustomers @var int $totalOrders @var float $totalSales @var int $pendingOrders @var int $waitingVerifications @var array $dailySales @var array $recentOrders @var array $lowStockProducts */ ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 mb-2">ROLE: ADMINISTRATOR</span>
                <h1 class="fw-bold mb-0">Dashboard Admin ShopEase</h1>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="<?= site_url('admin/orders') ?>" class="btn btn-cyber btn-sm px-3"><i class="bi bi-clipboard-check me-1"></i> Pesanan</a>
                <a href="<?= site_url('admin/products') ?>" class="btn btn-outline-cyber btn-sm px-3"><i class="bi bi-controller me-1"></i> Produk</a>
                <a href="<?= site_url('admin/categories') ?>" class="btn btn-outline-cyber btn-sm px-3"><i class="bi bi-tags me-1"></i> Kategori</a>
            </div>
        </div>

        <!-- 6 Kartu Statistik -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-2">
                <div class="card-gaming p-3 h-100">
                    <div class="small text-secondary">Total Produk</div>
                    <div class="brand-font fs-3 fw-bold text-white"><?= $totalProducts ?></div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="card-gaming p-3 h-100">
                    <div class="small text-secondary">Customer</div>
                    <div class="brand-font fs-3 fw-bold text-white"><?= $totalCustomers ?></div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="card-gaming p-3 h-100">
                    <div class="small text-secondary">Total Order</div>
                    <div class="brand-font fs-3 fw-bold text-info"><?= $totalOrders ?></div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="card-gaming p-3 h-100">
                    <div class="small text-secondary">Menunggu Bayar</div>
                    <div class="brand-font fs-3 fw-bold text-warning"><?= $pendingOrders ?></div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="card-gaming p-3 h-100">
                    <div class="small text-secondary">Perlu Verifikasi</div>
                    <div class="brand-font fs-3 fw-bold text-danger"><?= $waitingVerifications ?></div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="card-gaming p-3 h-100">
                    <div class="small text-secondary">Total Penjualan</div>
                    <div class="brand-font fs-5 fw-bold text-success mt-1">Rp <?= number_format($totalSales, 0, ',', '.') ?></div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <!-- Grafik Penjualan -->
            <div class="col-lg-8">
                <div class="card-gaming p-4 h-100">
                    <h5 class="fw-bold text-info mb-3">Grafik Penjualan Harian</h5>
                    <canvas id="salesChart" height="120"></canvas>
                </div>
            </div>

            <!-- Stok Menipis -->
            <div class="col-lg-4">
                <div class="card-gaming p-4 h-100">
                    <h5 class="fw-bold text-warning mb-3"><i class="bi bi-exclamation-triangle me-2"></i>Stok Menipis (&le; 5)</h5>
                    <?php if (empty($lowStockProducts)): ?>
                        <p class="small text-secondary mb-0">Semua stok produk aman.</p>
                    <?php else: ?>
                        <ul class="list-unstyled d-grid gap-2 mb-0 small">
                            <?php foreach ($lowStockProducts as $lp): ?>
                                <li class="d-flex justify-content-between align-items-center p-2 rounded border border-secondary border-opacity-25">
                                    <span><?= esc($lp['name']) ?></span>
                                    <span class="badge <?= (int) $lp['stock'] === 0 ? 'bg-danger' : 'bg-warning text-dark' ?>">
                                        Stok <?= (int) $lp['stock'] ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Transaksi Terbaru -->
        <div class="card-gaming p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Pesanan Terbaru</h5>
                <a href="<?= site_url('admin/orders') ?>" class="text-info text-decoration-none small">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-dark table-sm align-middle mb-0">
                    <thead>
                        <tr class="text-secondary small">
                            <th>No. Order</th><th>Customer</th><th>Total</th><th>Status</th><th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentOrders as $ro): ?>
                            <tr>
                                <td class="text-info fw-semibold"><?= esc($ro['order_number']) ?></td>
                                <td><?= esc($ro['customer_name']) ?></td>
                                <td>Rp <?= number_format((float) $ro['total'], 0, ',', '.') ?></td>
                                <td><span class="badge bg-secondary"><?= esc(strtoupper($ro['order_status'])) ?></span></td>
                                <td class="text-end"><a href="<?= site_url('admin/orders/' . $ro['id_order']) ?>" class="btn btn-outline-cyber btn-sm py-0">Detail</a></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($recentOrders)): ?>
                            <tr><td colspan="5" class="text-center text-secondary py-3">Belum ada transaksi.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    const labels = <?= json_encode(array_column($dailySales, 'tanggal')) ?>;
    const values = <?= json_encode(array_map('floatval', array_column($dailySales, 'penjualan'))) ?>;

    new Chart(document.getElementById('salesChart'), {
        type: 'bar',
        data: {
            labels: labels.length ? labels : ['Belum ada transaksi'],
            datasets: [{
                label: 'Penjualan (Rp)',
                data: values.length ? values : [0],
                backgroundColor: 'rgba(0, 229, 255, 0.45)',
                borderColor: '#00e5ff',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            plugins: { legend: { labels: { color: '#9ca3af' } } },
            scales: {
                x: { ticks: { color: '#9ca3af' }, grid: { color: 'rgba(255,255,255,0.05)' } },
                y: { ticks: { color: '#9ca3af' }, grid: { color: 'rgba(255,255,255,0.05)' } }
            }
        }
    });
</script>
<?= $this->endSection() ?>