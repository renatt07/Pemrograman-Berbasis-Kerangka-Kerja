<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h1 class="mt-2">Dashboard Admin</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Ringkasan Operasional ShuttleHub</li>
</ol>

<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                <div class="small text-white-50">Total Lapangan</div>
                <div class="fs-3 fw-bold"><?= $totalCourts ?></div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= base_url('/admin/courts') ?>">Kelola Lapangan</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">
                <div class="small text-white-50">Menunggu Verifikasi</div>
                <div class="fs-3 fw-bold"><?= $pendingCount ?></div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= base_url('/admin/bookings') ?>">Periksa Booking</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                <div class="small text-white-50">Estimasi Pendapatan</div>
                <div class="fs-4 fw-bold">Rp <?= number_format($totalRevenue, 0, ',', '.') ?></div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <span class="small text-white">Booking Disetujui &amp; Selesai</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-secondary text-white mb-4">
            <div class="card-body">
                <div class="small text-white-50">Total Pelanggan</div>
                <div class="fs-3 fw-bold"><?= $totalCustomers ?></div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <span class="small text-white">Total Booking: <?= $totalBookings ?></span>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-clock me-1"></i> Booking Terbaru</span>
        <a href="<?= base_url('/admin/bookings') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Pelanggan</th>
                    <th>Lapangan</th>
                    <th>Jadwal</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recentBookings)) : ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">Belum ada data booking masuk.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($recentBookings as $b) : ?>
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
                            <td><?= esc($b['customer_name']) ?></td>
                            <td><?= esc($b['court_name']) ?></td>
                            <td><?= esc($b['booking_date']) ?> (<?= substr($b['start_time'], 0, 5) ?> - <?= substr($b['end_time'], 0, 5) ?>)</td>
                            <td>Rp <?= number_format($b['total_price'], 0, ',', '.') ?></td>
                            <td><span class="badge <?= $badge ?>"><?= strtoupper(esc($b['status'])) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>