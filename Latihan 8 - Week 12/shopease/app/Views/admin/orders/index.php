<?php /** @var array $orders @var string $statusFilter */ ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <span class="text-info small fw-bold text-uppercase">Order Management</span>
                <h2 class="fw-bold mb-0">Kelola Pesanan & Pengiriman</h2>
            </div>
            <form action="<?= site_url('admin/orders') ?>" method="GET" class="d-flex gap-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <?php foreach (['pending_payment', 'waiting_verification', 'processing', 'shipped', 'completed', 'cancelled'] as $st): ?>
                        <option value="<?= $st ?>" <?= $statusFilter === $st ? 'selected' : '' ?>>
                            <?= esc(str_replace('_', ' ', strtoupper($st))) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-cyber btn-sm px-3">Filter</button>
            </form>
        </div>

        <div class="card-gaming p-3 p-md-4">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr class="text-secondary small text-uppercase">
                            <th>No. Pesanan</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Pembayaran</th>
                            <th>Status Order</th>
                            <th>Resi</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $o): ?>
                            <tr>
                                <td class="fw-bold text-info"><?= esc($o['order_number']) ?></td>
                                <td>
                                    <div class="fw-semibold small"><?= esc($o['customer_name']) ?></div>
                                    <div class="text-secondary" style="font-size: 0.75rem;"><?= date('d/m/Y H:i', strtotime($o['created_at'])) ?></div>
                                </td>
                                <td class="brand-font fw-bold">Rp <?= number_format((float) $o['total'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge <?= ($o['payment_status'] ?? '') === 'submitted' ? 'bg-warning text-dark' : (($o['payment_status'] ?? '') === 'verified' ? 'bg-success' : 'bg-secondary') ?>">
                                        <?= esc(strtoupper((string) ($o['payment_status'] ?? 'unpaid'))) ?>
                                    </span>
                                </td>
                                <td><span class="badge bg-info bg-opacity-25 text-info"><?= esc(str_replace('_', ' ', strtoupper($o['order_status']))) ?></span></td>
                                <td class="small text-secondary"><?= esc($o['tracking_number'] ?: '-') ?></td>
                                <td class="text-end">
                                    <a href="<?= site_url('admin/orders/' . $o['id_order']) ?>" class="btn btn-outline-cyber btn-sm">
                                        Kelola
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($orders)): ?>
                            <tr><td colspan="7" class="text-center text-secondary py-4">Belum ada pesanan masuk.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>