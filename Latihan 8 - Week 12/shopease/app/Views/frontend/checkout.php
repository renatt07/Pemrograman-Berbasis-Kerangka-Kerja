<?php /** @var array $user @var array $items @var float $subtotal @var array $shippingRates */ ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="mb-4">
            <span class="text-info small fw-bold text-uppercase">Checkout</span>
            <h1 class="fw-bold mb-0">Konfirmasi Pengiriman & Pembayaran</h1>
        </div>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger small mb-4">
                <ul class="mb-0 ps-3">
                    <?php foreach (session()->getFlashdata('errors') as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('checkout/process') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="row g-4">
                <!-- Form Pengiriman -->
                <div class="col-lg-7">
                    <div class="card-gaming p-4 mb-4">
                        <h5 class="fw-bold text-info mb-3"><i class="bi bi-geo-alt me-2"></i>Alamat Pengiriman</h5>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small text-secondary">Nama Penerima <span class="text-danger">*</span></label>
                                <input type="text" name="recipient_name" class="form-control"
                                       value="<?= esc(old('recipient_name', $user['name'] ?? '')) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-secondary">Nomor Telepon <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control"
                                       value="<?= esc(old('phone', $user['phone'] ?? '')) ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-secondary">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="shipping_address" class="form-control" rows="3" required placeholder="Jalan, nomor rumah, kecamatan, kota, kode pos"><?= esc(old('shipping_address', $user['address'] ?? '')) ?></textarea>
                        </div>
                        <div class="mb-0">
                            <label class="form-label small text-secondary">Catatan Pesanan (Opsional)</label>
                            <input type="text" name="notes" class="form-control" value="<?= esc(old('notes')) ?>" placeholder="Contoh: Packing kayu / titip di satpam">
                        </div>
                    </div>

                    <div class="card-gaming p-4">
                        <h5 class="fw-bold text-info mb-3"><i class="bi bi-truck me-2"></i>Pengiriman & Metode Pembayaran</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small text-secondary">Layanan Pengiriman</label>
                                <select name="shipping_service" id="shippingService" class="form-select" required>
                                    <?php foreach ($shippingRates as $key => $rate): ?>
                                        <option value="<?= esc($key) ?>" data-cost="<?= (int) $rate['cost'] ?>" <?= old('shipping_service', 'reguler') === $key ? 'selected' : '' ?>>
                                            <?= esc($rate['label']) ?> — Rp <?= number_format($rate['cost'], 0, ',', '.') ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-secondary">Metode Pembayaran Manual</label>
                                <select name="payment_method" class="form-select" required>
                                    <option value="Transfer Bank BCA">Transfer Bank BCA</option>
                                    <option value="Transfer Bank Mandiri">Transfer Bank Mandiri</option>
                                    <option value="QRIS / E-Wallet">QRIS / E-Wallet</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Order -->
                <div class="col-lg-5">
                    <div class="card-gaming p-4">
                        <h5 class="fw-bold mb-3">Ringkasan Pesanan</h5>
                        <div class="d-grid gap-3 mb-3">
                            <?php foreach ($items as $item): ?>
                                <div class="d-flex justify-content-between align-items-center small">
                                    <div>
                                        <div class="fw-semibold text-white"><?= esc($item['name']) ?></div>
                                        <div class="text-secondary"><?= (int) $item['quantity'] ?> × Rp <?= number_format((float) $item['price'], 0, ',', '.') ?></div>
                                    </div>
                                    <div class="fw-semibold">Rp <?= number_format((float) $item['line_subtotal'], 0, ',', '.') ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <hr class="border-secondary opacity-25">
                        <div class="d-flex justify-content-between small text-secondary mb-2">
                            <span>Subtotal</span>
                            <span class="text-white">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                        </div>
                        <div class="d-flex justify-content-between small text-secondary mb-3">
                            <span>Ongkos Kirim</span>
                            <span class="text-white" id="shippingCostDisplay">Rp 25.000</span>
                        </div>
                        <hr class="border-secondary opacity-25">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold">Total Pembayaran</span>
                            <span class="brand-font fs-4 fw-bold text-info" id="grandTotalDisplay">
                                Rp <?= number_format($subtotal + 25000, 0, ',', '.') ?>
                            </span>
                        </div>

                        <button type="submit" class="btn btn-cyber btn-lg w-100">
                            <i class="bi bi-lock-fill me-2"></i> Buat Pesanan Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const subtotalVal = <?= (float) $subtotal ?>;
    const shipSelect  = document.getElementById('shippingService');
    const fmtRp = (n) => 'Rp ' + new Intl.NumberFormat('id-ID').format(n);

    function updateCheckoutTotal() {
        const opt  = shipSelect.options[shipSelect.selectedIndex];
        const cost = parseInt(opt.getAttribute('data-cost') || '0', 10);
        document.getElementById('shippingCostDisplay').textContent = fmtRp(cost);
        document.getElementById('grandTotalDisplay').textContent   = fmtRp(subtotalVal + cost);
    }

    shipSelect.addEventListener('change', updateCheckoutTotal);
    updateCheckoutTotal();
</script>
<?= $this->endSection() ?>