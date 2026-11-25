<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h1 class="mt-2">Kelola Booking</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Verifikasi bukti pembayaran dan perbarui status pemesanan</li>
</ol>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-calendar-check me-1"></i> Daftar Semua Pemesanan
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Pelanggan</th>
                    <th>Lapangan</th>
                    <th>Tanggal &amp; Jam</th>
                    <th>Total</th>
                    <th>Bukti Bayar</th>
                    <th>Status</th>
                    <th style="width: 220px;">Ubah Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($bookings)) : ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Belum ada transaksi booking.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($bookings as $b) : ?>
                        <?php
                            $badge = match ($b['status']) {
                                'confirmed' => 'bg-primary',
                                'completed' => 'bg-success',
                                'cancelled' => 'bg-danger',
                                default     => 'bg-warning text-dark',
                            };
                        ?>
                        <tr>
                            <td>#<?= $b['id'] ?></td>
                            <td>
                                <div class="fw-semibold"><?= esc($b['customer_name']) ?></div>
                                <small class="text-muted"><?= esc($b['customer_phone']) ?></small>
                            </td>
                            <td>
                                <div><?= esc($b['court_name']) ?></div>
                                <small class="text-muted"><?= esc($b['floor_type']) ?></small>
                            </td>
                            <td>
                                <div><?= esc($b['booking_date']) ?></div>
                                <small class="text-muted"><?= substr($b['start_time'], 0, 5) ?> - <?= substr($b['end_time'], 0, 5) ?> (<?= $b['duration'] ?> jam)</small>
                            </td>
                            <td class="fw-semibold">Rp <?= number_format($b['total_price'], 0, ',', '.') ?></td>
                            <td>
                                <?php if (! empty($b['payment_proof'])) : ?>
                                    <a href="<?= base_url('uploads/payments/' . $b['payment_proof']) ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-image me-1"></i>Lihat
                                    </a>
                                <?php else : ?>
                                    <span class="text-muted small">Belum upload</span>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge <?= $badge ?>"><?= strtoupper(esc($b['status'])) ?></span></td>
                            <td>
                                <form action="<?= base_url('/admin/bookings/status/' . $b['id']) ?>" method="post" class="d-flex gap-1">
                                    <?= csrf_field() ?>
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="pending" <?= $b['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="confirmed" <?= $b['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                        <option value="completed" <?= $b['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                        <option value="cancelled" <?= $b['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>