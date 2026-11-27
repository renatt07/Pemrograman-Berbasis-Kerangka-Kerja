<?php /** @var array $order @var array $items @var ?array $payment @var ?array $shipment */ ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <a href="<?= site_url('admin/orders') ?>" class="text-secondary text-decoration-none small">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pesanan
                </a>
                <h2 class="fw-bold mt-1 mb-0">Kelola Pesanan <?= esc($order['order_number']) ?></h2>
            </div>
            <?php if (!in_array($order['order_status'], ['shipped', 'completed', 'cancelled'], true)): ?>
                <form action="<?= site_url('admin/orders/' . $order['id_order'] . '/cancel') ?>" method="POST" onsubmit="return confirm('Batalkan pesanan ini? Stok produk akan otomatis dikembalikan.')">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-x-circle me-1"></i> Batalkan Pesanan
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <div class="row g-4">
            <!-- Info Customer & Item -->
            <div class="col-lg-7">
                <div class="card-gaming p-4 mb-4">
                    <h5 class="fw-bold text-info mb-3">Item Pesanan</h5>
                    <table class="table table-dark table-sm align-middle mb-0">
                        <thead>
                            <tr class="text-secondary small">
                                <th>Produk</th><th>Harga</th><th>Qty</th><th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $it): ?>
                                <tr>
                                    <td><?= esc($it['product_name']) ?></td>
                                    <td>Rp <?= number_format((float) $it['price'], 0, ',', '.') ?></td>
                                    <td><?= (int) $it['quantity'] ?></td>
                                    <td class="text-end">Rp <?= number_format((float) $it['subtotal'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <hr class="border-secondary opacity-25">
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total (+ Ongkir Rp <?= number_format((float) $order['shipping_cost'], 0, ',', '.') ?>)</span>
                        <span class="brand-font text-info fs-5">Rp <?= number_format((float) $order['total'], 0, ',', '.') ?></span>
                    </div>
                </div>

                <div class="card-gaming p-4">
                    <h5 class="fw-bold text-info mb-3">Pengiriman & Nomor Resi (Admin / Operator)</h5>
                    <p class="small mb-3">
                        <strong>Penerima:</strong> <?= esc($order['recipient_name']) ?> (<?= esc($order['phone']) ?>)<br>
                        <span class="text-secondary"><?= nl2br(esc($order['shipping_address'])) ?></span>
                    </p>

                    <form action="<?= site_url('admin/orders/' . $order['id_order'] . '/shipment') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label small text-secondary">Kurir</label>
                                <input type="text" name="courier" class="form-control form-control-sm"
                                       value="<?= esc($shipment['courier'] ?? '') ?>" placeholder="JNE / J&T / SiCepat" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-secondary">Nomor Resi</label>
                                <input type="text" name="tracking_number" class="form-control form-control-sm"
                                       value="<?= esc($shipment['tracking_number'] ?? '') ?>" placeholder="Nomor resi pengiriman" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-secondary">Status Kirim</label>
                                <select name="shipment_status" class="form-select form-select-sm">
                                    <?php foreach (['pending', 'shipped', 'delivered'] as $ss): ?>
                                        <option value="<?= $ss ?>" <?= ($shipment['shipment_status'] ?? 'pending') === $ss ? 'selected' : '' ?>>
                                            <?= esc(strtoupper($ss)) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-cyber btn-sm px-4" <?= !in_array($order['order_status'], ['processing', 'shipped'], true) ? 'disabled' : '' ?>>
                            <i class="bi bi-truck me-1"></i> Simpan Pengiriman
                        </button>
                    </form>
                </div>
            </div>

            <!-- Panel Verifikasi Pembayaran -->
            <div class="col-lg-5">
                <div class="card-gaming p-4">
                    <h5 class="fw-bold text-info mb-3">Verifikasi Pembayaran</h5>
                    <div class="small mb-3">
                        <div><strong>Metode:</strong> <?= esc($payment['method'] ?? '-') ?></div>
                        <div><strong>Status:</strong> <span class="badge bg-secondary"><?= esc(strtoupper($payment['payment_status'] ?? 'unpaid')) ?></span></div>
                    </div>

                    <?php if (!empty($payment['proof_file'])): ?>
                        <a href="<?= base_url('uploads/payments/' . esc($payment['proof_file'])) ?>" target="_blank">
                            <img src="<?= base_url('uploads/payments/' . esc($payment['proof_file'])) ?>"
                                 alt="Bukti Bayar" class="img-fluid rounded border border-secondary mb-3" style="max-height: 280px;">
                        </a>
                    <?php else: ?>
                        <p class="small text-secondary mb-3">Customer belum mengunggah bukti pembayaran.</p>
                    <?php endif; ?>

                    <?php if (session()->get('role') === 'admin'): ?>
                        <?php if ($payment && $payment['payment_status'] === 'submitted' && $order['order_status'] !== 'cancelled'): ?>
                            <div class="d-flex gap-2">
                                <form action="<?= site_url('admin/orders/' . $order['id_order'] . '/verify-payment') ?>" method="POST" class="w-50">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn btn-success btn-sm w-100">
                                        <i class="bi bi-check-lg me-1"></i> Approve
                                    </button>
                                </form>
                                <form action="<?= site_url('admin/orders/' . $order['id_order'] . '/verify-payment') ?>" method="POST" class="w-50">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" class="btn btn-danger btn-sm w-100">
                                        <i class="bi bi-x-lg me-1"></i> Reject
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="small text-warning">Verifikasi pembayaran hanya dapat dilakukan oleh Administrator.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>