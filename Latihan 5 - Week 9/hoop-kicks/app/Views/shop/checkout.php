<?php
/**
 * @var array      $items
 * @var int        $total
 * @var array|null $user
 */
?>
<?= $this->extend('layout/store') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="mb-4">
        <a href="<?= base_url('/cart') ?>" class="font-mono small text-dark text-decoration-none">&larr; KEMBALI KE KERANJANG</a>
        <h1 class="font-display display-4 fw-bold mt-2 mb-0">CHECKOUT PESANAN</h1>
    </div>

    <form action="<?= base_url('/checkout') ?>" method="post">
        <?= csrf_field() ?>
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="hk-card p-4">
                    <h5 class="font-display fs-3 fw-bold mb-3">DATA PENGIRIMAN &amp; PEMBAYARAN</h5>

                    <div class="mb-3">
                        <label class="form-label font-mono small fw-bold text-uppercase">Nama Penerima</label>
                        <input type="text" name="recipient_name" class="form-control" value="<?= old('recipient_name', $user['name'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-mono small fw-bold text-uppercase">Nomor WhatsApp / HP</label>
                        <input type="text" name="phone" class="form-control" value="<?= old('phone', $user['phone'] ?? '') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-mono small fw-bold text-uppercase">Alamat Lengkap</label>
                        <textarea name="shipping_address" class="form-control" rows="3" required><?= old('shipping_address', $user['address'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-mono small fw-bold text-uppercase">Metode Pembayaran</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="Transfer Bank BCA">Transfer Bank BCA — 8820-1122-33 a.n. HoopKicks</option>
                            <option value="QRIS Instant">QRIS Instant</option>
                            <option value="Virtual Account Mandiri">Virtual Account Mandiri</option>
                            <option value="COD Surabaya">COD Surabaya (Pickup / Kurir Lokal)</option>
                        </select>
                    </div>

                    <div class="mb-0">
                        <label class="form-label font-mono small fw-bold text-uppercase">Catatan Kurir (Opsional)</label>
                        <input type="text" name="notes" class="form-control" value="<?= old('notes') ?>" placeholder="Contoh: Packing double box tebal, kirim sore hari">
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="hk-card p-4">
                    <h5 class="font-display fs-3 fw-bold pb-3 mb-3 border-bottom border-dark">ITEM PESANAN</h5>

                    <?php foreach ($items as $it) : ?>
                        <div class="d-flex justify-content-between align-items-start py-2 border-bottom border-dark-subtle small">
                            <div>
                                <div class="fw-bold"><?= esc($it['name']) ?></div>
                                <div class="font-mono text-muted" style="font-size: 0.74rem;">
                                    Size <?= esc($it['shoe_size']) ?> &times; <?= $it['quantity'] ?>
                                </div>
                            </div>
                            <div class="font-mono fw-bold">
                                Rp <?= number_format($it['subtotal'], 0, ',', '.') ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="d-flex justify-content-between align-items-center pt-3 mt-2 mb-4">
                        <span class="font-mono small fw-bold">TOTAL PEMBAYARAN</span>
                        <span class="font-mono fs-4 fw-bold" style="color: var(--hk-accent);">
                            Rp <?= number_format($total, 0, ',', '.') ?>
                        </span>
                    </div>

                    <button type="submit" class="hk-btn hk-btn-accent w-100 py-3">
                        Buat Pesanan Sekarang &rarr;
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>