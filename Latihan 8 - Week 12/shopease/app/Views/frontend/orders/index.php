<?php /** @var array $orders */ ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="mb-4">
            <span class="text-info small fw-bold text-uppercase">Order History</span>
            <h1 class="fw-bold mb-0">Pesanan Saya</h1>
        </div>

        <?php if (empty($orders)): ?>
            <div class="card-gaming p-5 text-center">
                <i class="bi bi-receipt fs-1 text-secondary d-block mb-3"></i>
                <h4 class="fw-bold">Belum ada pesanan</h4>
                <p class="text-secondary mb-4">Riwayat transaksi Anda akan muncul di sini setelah melakukan checkout.</p>
                <a href="<?= site_url('catalog') ?>" class="btn btn-cyber px-4">Lihat Katalog</a>
            </div>
        <?php else: ?>
            <div class="card-gaming p-3 p-md-4">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                            <tr class="text-secondary small text-uppercase">
                                <th>No. Pesanan</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Pembayaran</th>
                                <th>Status Pesanan</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $o): ?>
                                <tr>
                                    <td class="fw-bold text-info"><?= esc($o['order_number']) ?></td>
                                    <td class="small text-secondary"><?= date('d M Y, H:i', strtotime($o['created_at'])) ?></td>
                                    <td class="brand-font fw-bold">Rp <?= number_format((float) $o['total'], 0, ',', '.') ?></td>
                                    <td><span class="badge bg-secondary"><?= esc(strtoupper((string) ($o['payment_status'] ?? 'unpaid'))) ?></span></td>
                                    <td><span class="badge bg-info bg-opacity-25 text-info border border-info border-opacity-50"><?= esc(str_replace('_', ' ', strtoupper($o['order_status']))) ?></span></td>
                                    <td class="text-end">
                                        <a href="<?= site_url('orders/' . $o['id_order']) ?>" class="btn btn-outline-cyber btn-sm">
                                            Detail & Bayar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection() ?>