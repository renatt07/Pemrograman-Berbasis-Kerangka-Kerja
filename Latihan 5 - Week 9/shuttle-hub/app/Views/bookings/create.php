<?php
/** @var array $court */
?>
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary btn-sm mb-3">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Lapangan
    </a>

    <div class="row g-4">
        <!-- Info Lapangan & Rekening -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden mb-3">
                <?php if (! empty($court['image'])) : ?>
                    <img src="<?= base_url('uploads/courts/' . $court['image']) ?>" class="w-100" style="height: 220px; object-fit: cover;" alt="<?= esc($court['name']) ?>">
                <?php endif; ?>
                <div class="card-body">
                    <span class="badge bg-primary-subtle text-primary mb-2"><?= esc($court['floor_type']) ?></span>
                    <h4 class="fw-bold mb-1"><?= esc($court['name']) ?></h4>
                    <p class="text-muted small mb-3"><?= esc($court['description']) ?></p>
                    <div class="fs-5 fw-bold text-primary">
                        Rp <?= number_format($court['price_per_hour'], 0, ',', '.') ?> <span class="fs-6 fw-normal text-muted">/ jam</span>
                    </div>
                </div>
            </div>

            <div class="card border-0 bg-primary-subtle rounded-3">
                <div class="card-body small">
                    <h6 class="fw-bold text-primary mb-2"><i class="bi bi-bank me-1"></i>Info Pembayaran Transfer</h6>
                    <p class="mb-1"><strong>Bank BCA:</strong> 1234-5678-90 a.n. ShuttleHub Arena</p>
                    <p class="mb-0 text-muted">Anda dapat langsung mengunggah bukti transfer sekarang atau menyusul lewat halaman <strong>Booking Saya</strong>.</p>
                </div>
            </div>
        </div>

        <!-- Form Booking -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3">Form Pemesanan Lapangan</h4>

                    <form action="<?= base_url('/booking/store') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="court_id" value="<?= $court['id'] ?>">

                        <div class="mb-3">
                            <label for="booking_date" class="form-label fw-semibold">Tanggal Main</label>
                            <input type="date" class="form-control" id="booking_date" name="booking_date"
                                   min="<?= date('Y-m-d') ?>"
                                   value="<?= old('booking_date', date('Y-m-d')) ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_hour" class="form-label fw-semibold">Jam Mulai</label>
                                <select class="form-select" id="start_hour" name="start_hour" required>
                                    <?php $oldStart = (int) old('start_hour', 8); ?>
                                    <?php for ($h = 7; $h <= 21; $h++) : ?>
                                        <option value="<?= $h ?>" <?= $oldStart === $h ? 'selected' : '' ?>>
                                            <?= sprintf('%02d:00', $h) ?> WIB
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="duration" class="form-label fw-semibold">Durasi Main</label>
                                <select class="form-select" id="duration" name="duration" required>
                                    <?php $oldDuration = (int) old('duration', 1); ?>
                                    <?php for ($d = 1; $d <= 4; $d++) : ?>
                                        <option value="<?= $d ?>" <?= $oldDuration === $d ? 'selected' : '' ?>>
                                            <?= $d ?> Jam
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Ringkasan Harga Otomatis -->
                        <div class="alert alert-light border d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <div class="small text-muted">Estimasi Total Pembayaran</div>
                                <div class="small text-muted" id="timeSummary">08:00 – 09:00 WIB</div>
                            </div>
                            <div class="fs-4 fw-bold text-primary" id="totalPriceText">
                                Rp <?= number_format($court['price_per_hour'], 0, ',', '.') ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="payment_proof" class="form-label fw-semibold">Upload Bukti Transfer <span class="text-muted fw-normal">(opsional sekarang, maks 2 MB)</span></label>
                            <input type="file" class="form-control" id="payment_proof" name="payment_proof" accept="image/*">
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label fw-semibold">Catatan Tambahan <span class="text-muted fw-normal">(opsional)</span></label>
                            <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Contoh: Pinjam net cadangan / datang 10 menit lebih awal"><?= old('notes') ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
                            <i class="bi bi-check-circle me-1"></i>Konfirmasi Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const pricePerHour = <?= (int) $court['price_per_hour'] ?>;
    const startEl      = document.getElementById('start_hour');
    const durationEl   = document.getElementById('duration');
    const totalEl      = document.getElementById('totalPriceText');
    const summaryEl    = document.getElementById('timeSummary');

    function updateSummary() {
        const start    = parseInt(startEl.value, 10);
        const duration = parseInt(durationEl.value, 10);
        const end      = start + duration;
        const total    = pricePerHour * duration;

        const pad = (n) => String(n).padStart(2, '0') + ':00';
        summaryEl.textContent = `${pad(start)} – ${pad(end)} WIB (${duration} jam)`;
        totalEl.textContent   = 'Rp ' + total.toLocaleString('id-ID');
    }

    startEl.addEventListener('change', updateSummary);
    durationEl.addEventListener('change', updateSummary);
    updateSummary();
</script>
<?= $this->endSection() ?>