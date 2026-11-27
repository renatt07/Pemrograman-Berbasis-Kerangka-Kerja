<?php /** @var array $order @var array $items @var ?array $payment @var ?array $shipment */ ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <a href="<?= site_url('orders') ?>" class="text-secondary text-decoration-none small">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat Pesanan
                </a>
                <h2 class="fw-bold mt-1 mb-0">Pesanan <?= esc($order['order_number']) ?></h2>
            </div>
            <span class="badge bg-info text-dark fs-6 px-3 py-2">
                <?= esc(str_replace('_', ' ', strtoupper($order['order_status']))) ?>
            </span>
        </div>

        <div class="row g-4">
            <!-- Rincian Item & Pengiriman -->
            <div class="col-lg-7">
                <div class="card-gaming p-4 mb-4">
                    <h5 class="fw-bold text-info mb-3">Rincian Item (Snapshot Harga)</h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-sm align-middle mb-0">
                            <thead>
                                <tr class="text-secondary small">
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $it): ?>
                                    <tr>
                                        <td class="fw-semibold"><?= esc($it['product_name']) ?></td>
                                        <td>Rp <?= number_format((float) $it['price'], 0, ',', '.') ?></td>
                                        <td><?= (int) $it['quantity'] ?></td>
                                        <td class="text-end">Rp <?= number_format((float) $it['subtotal'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <hr class="border-secondary opacity-25">
                    <div class="d-flex justify-content-between small text-secondary mb-1">
                        <span>Subtotal</span><span>Rp <?= number_format((float) $order['subtotal'], 0, ',', '.') ?></span>
                    </div>
                    <div class="d-flex justify-content-between small text-secondary mb-2">
                        <span>Ongkos Kirim</span><span>Rp <?= number_format((float) $order['shipping_cost'], 0, ',', '.') ?></span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span><span class="brand-font text-info">Rp <?= number_format((float) $order['total'], 0, ',', '.') ?></span>
                    </div>
                </div>

                <!-- Alamat & Tracking Resi -->
                <div class="card-gaming p-4">
                    <h5 class="fw-bold text-info mb-3">Pengiriman & Pelacakan</h5>
                    <p class="small mb-1"><strong>Penerima:</strong> <?= esc($order['recipient_name']) ?> (<?= esc($order['phone']) ?>)</p>
                    <p class="small text-secondary mb-3"><?= nl2br(esc($order['shipping_address'])) ?></p>

                    <?php if ($shipment && !empty($shipment['tracking_number'])): ?>
                        <div class="p-3 rounded border border-info border-opacity-25 bg-info bg-opacity-10 small mb-3">
                            <div><strong>Kurir:</strong> <?= esc($shipment['courier']) ?></div>
                            <div><strong>Nomor Resi:</strong> <code class="text-info fs-6"><?= esc($shipment['tracking_number']) ?></code></div>
                            <div><strong>Status Kirim:</strong> <?= esc(strtoupper($shipment['shipment_status'])) ?></div>
                        </div>
                    <?php else: ?>
                        <p class="small text-secondary mb-0">Nomor resi akan muncul setelah pesanan dikirim oleh Operator.</p>
                    <?php endif; ?>

                    <?php if ($order['order_status'] === 'shipped'): ?>
                        <form action="<?= site_url('orders/' . $order['id_order'] . '/complete') ?>" method="POST" class="mt-3" onsubmit="return confirm('Konfirmasi bahwa paket sudah diterima dengan baik?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-cyber btn-sm px-4">
                                <i class="bi bi-check2-circle me-1"></i> Pesanan Diterima (Selesaikan)
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Panel Pembayaran & Upload Bukti -->
            <div class="col-lg-5">
                <div class="card-gaming p-4">
                    <h5 class="fw-bold text-info mb-3">Pembayaran Manual</h5>
                    <div class="small mb-3">
                        <div><strong>Metode:</strong> <?= esc($payment['method'] ?? '-') ?></div>
                        <div><strong>Status Pembayaran:</strong> <span class="badge bg-secondary"><?= esc(strtoupper($payment['payment_status'] ?? 'unpaid')) ?></span></div>
                    </div>

                    <div class="p-3 rounded border border-secondary small text-secondary mb-3" style="background: #0d1321;">
                        <div class="text-white fw-semibold mb-1">Instruksi Transfer (Demo)</div>
                        <div>Rekening: <strong>BCA 888-0123-456 a.n. ShopEase Gear</strong></div>
                        <div>Nominal: <strong class="text-info">Rp <?= number_format((float) $order['total'], 0, ',', '.') ?></strong></div>
                    </div>

                    <?php if (!empty($payment['proof_file'])): ?>
                        <div class="mb-3">
                            <div class="small text-secondary mb-2">Bukti Pembayaran Terunggah:</div>
                            <img src="<?= base_url('uploads/payments/' . esc($payment['proof_file'])) ?>"
                                 alt="Bukti Bayar" class="img-fluid rounded border border-secondary" style="max-height: 260px;">
                        </div>
                    <?php endif; ?>

                    <?php if ($payment && in_array($payment['payment_status'], ['unpaid', 'rejected'], true) && $order['order_status'] !== 'cancelled'): ?>
                        <?php if ($payment['payment_status'] === 'rejected'): ?>
                            <div class="alert alert-warning small">Bukti pembayaran sebelumnya ditolak. Silakan unggah bukti transfer yang jelas.</div>
                        <?php endif; ?>
                        <form action="<?= site_url('orders/' . $order['id_order'] . '/payment') ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label small text-secondary">Unggah Bukti Transfer (JPG/PNG/WEBP, maks 2 MB)</label>
                                <input type="file" name="proof" class="form-control form-control-sm" accept="image/jpeg,image/png,image/webp" required>
                            </div>
                            <button type="submit" class="btn btn-cyber w-100">
                                <i class="bi bi-upload me-1"></i> Upload Bukti Pembayaran
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>