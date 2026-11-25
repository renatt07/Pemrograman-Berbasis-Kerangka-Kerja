<?php
/** @var array $bookings */
?>
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Booking Saya</h2>
            <p class="text-muted mb-0">Pantau status verifikasi dan unggah bukti pembayaran Anda</p>
        </div>
        <a href="<?= base_url('/#daftar-lapangan') ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Booking Lapangan Baru
        </a>
    </div>

    <?php if (empty($bookings)) : ?>
        <div class="card border-0 shadow-sm text-center py-5">
            <div class="card-body">
                <i class="bi bi-calendar-x fs-1 text-muted mb-2 d-block"></i>
                <h5 class="fw-semibold">Belum ada riwayat booking</h5>
                <p class="text-muted small mb-3">Yuk pilih lapangan badminton favorit Anda sekarang.</p>
                <a href="<?= base_url('/#daftar-lapangan') ?>" class="btn btn-primary">Lihat Lapangan</a>
            </div>
        </div>
    <?php else : ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Lapangan</th>
                            <th>Jadwal Main</th>
                            <th>Total</th>
                            <th>Bukti Bayar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
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
                                <td class="fw-semibold">#<?= $b['id'] ?></td>
                                <td>
                                    <div class="fw-semibold"><?= esc($b['court_name']) ?></div>
                                    <small class="text-muted"><?= esc($b['floor_type']) ?></small>
                                </td>
                                <td>
                                    <div><?= esc($b['booking_date']) ?></div>
                                    <small class="text-muted"><?= substr($b['start_time'], 0, 5) ?> – <?= substr($b['end_time'], 0, 5) ?> (<?= $b['duration'] ?> jam)</small>
                                </td>
                                <td class="fw-semibold">Rp <?= number_format($b['total_price'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if (! empty($b['payment_proof'])) : ?>
                                        <a href="<?= base_url('uploads/payments/' . $b['payment_proof']) ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-image me-1"></i>Lihat Bukti
                                        </a>
                                    <?php else : ?>
                                        <span class="text-muted small">Belum diunggah</span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="badge <?= $badge ?>"><?= strtoupper(esc($b['status'])) ?></span></td>
                                <td>
                                    <?php if ($b['status'] === 'pending') : ?>
                                        <div class="d-flex flex-column gap-2" style="min-width: 210px;">
                                            <form action="<?= base_url('/my-bookings/upload/' . $b['id']) ?>" method="post" enctype="multipart/form-data" class="d-flex gap-1">
                                                <?= csrf_field() ?>
                                                <input type="file" name="payment_proof" class="form-control form-control-sm" accept="image/*" required>
                                                <button type="submit" class="btn btn-sm btn-outline-primary">Upload</button>
                                            </form>
                                            <form action="<?= base_url('/my-bookings/cancel/' . $b['id']) ?>" method="post" onsubmit="return confirm('Batalkan booking ini?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">Batalkan Booking</button>
                                            </form>
                                        </div>
                                    <?php else : ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>