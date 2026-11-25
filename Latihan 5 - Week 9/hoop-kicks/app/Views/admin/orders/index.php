<?php
/** @var array $orders */
?>
<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <div class="font-mono small text-muted">ORDER FULFILLMENT</div>
    <h1 class="font-display display-5 fw-bold mb-0">KELOLA PESANAN MASUK</h1>
</div>

<?php if (empty($orders)) : ?>
    <div class="hk-card p-5 text-center text-muted font-mono small">
        BELUM ADA PESANAN MASUK.
    </div>
<?php else : ?>
    <div class="d-flex flex-column gap-3">
        <?php foreach ($orders as $o) : ?>
            <div class="hk-card">
                <div class="p-3 bg-dark text-white d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div class="font-mono small">
                        <strong style="color: var(--hk-acid);"><?= esc($o['order_code']) ?></strong>
                        <span class="text-white-50 ms-2"><?= esc($o['created_at']) ?></span>
                    </div>

                    <form action="<?= base_url('/admin/orders/status/' . $o['id']) ?>" method="post" class="d-flex align-items-center gap-2">
                        <?= csrf_field() ?>
                        <select name="status" class="form-select form-select-sm font-mono" style="width: auto;" <?= $o['status'] === 'cancelled' ? 'disabled' : '' ?>>
                            <option value="pending" <?= $o['status'] === 'pending' ? 'selected' : '' ?>>PENDING</option>
                            <option value="paid" <?= $o['status'] === 'paid' ? 'selected' : '' ?>>PAID</option>
                            <option value="shipped" <?= $o['status'] === 'shipped' ? 'selected' : '' ?>>SHIPPED</option>
                            <option value="completed" <?= $o['status'] === 'completed' ? 'selected' : '' ?>>COMPLETED</option>
                            <option value="cancelled" <?= $o['status'] === 'cancelled' ? 'selected' : '' ?>>CANCELLED</option>
                        </select>
                        <?php if ($o['status'] !== 'cancelled') : ?>
                            <button type="submit" class="hk-btn hk-btn-accent hk-btn-sm">Update</button>
                        <?php else : ?>
                            <span class="hk-tag hk-tag-accent">DIBATALKAN</span>
                        <?php endif; ?>
                    </form>
                </div>

                <div class="p-3 p-md-4">
                    <div class="row g-3 small mb-3">
                        <div class="col-md-4">
                            <div class="font-mono text-muted" style="font-size: 0.7rem;">PENERIMA / AKUN</div>
                            <div class="fw-bold"><?= esc($o['recipient_name']) ?></div>
                            <div class="text-muted"><?= esc($o['phone']) ?> &middot; <?= esc($o['account_email']) ?></div>
                        </div>
                        <div class="col-md-5">
                            <div class="font-mono text-muted" style="font-size: 0.7rem;">ALAMAT &amp; CATATAN</div>
                            <div><?= esc($o['shipping_address']) ?></div>
                            <?php if (! empty($o['notes'])) : ?>
                                <div class="text-muted fst-italic mt-1">Catatan: <?= esc($o['notes']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-3">
                            <div class="font-mono text-muted" style="font-size: 0.7rem;">METODE &amp; TOTAL</div>
                            <div><?= esc($o['payment_method']) ?></div>
                            <div class="font-mono fw-bold fs-6 mt-1" style="color: var(--hk-accent);">
                                Rp <?= number_format($o['total_price'], 0, ',', '.') ?>
                            </div>
                        </div>
                    </div>

                    <div class="border-top border-dark-subtle pt-2">
                        <?php foreach ($o['items'] as $it) : ?>
                            <div class="d-flex justify-content-between py-1 small">
                                <div>
                                    <span class="fw-semibold"><?= esc($it['product_name']) ?></span>
                                    <span class="hk-tag hk-tag-light ms-1">Size <?= esc($it['shoe_size']) ?></span>
                                    <span class="font-mono text-muted ms-1">&times; <?= $it['quantity'] ?></span>
                                </div>
                                <div class="font-mono">Rp <?= number_format($it['subtotal'], 0, ',', '.') ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>