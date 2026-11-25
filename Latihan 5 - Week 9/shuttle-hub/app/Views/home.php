<?php
/**
 * @var array       $courts
 * @var array       $floors
 * @var string|null $floorFilter
 */
?>
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Hero Banner -->
<section class="sh-hero text-white py-5">
    <div class="container py-4 position-relative">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="sh-pill-tag mb-3">
                    <i class="bi bi-clock"></i> Buka Setiap Hari &middot; 07:00 – 22:00 WIB
                </span>
                <h1 class="display-4 fw-bold lh-sm mb-3">
                    Booking Lapangan Badminton <span style="color: var(--sh-lime);">Tanpa Antre.</span>
                </h1>
                <p class="lead text-white-50 mb-4 col-xl-10">
                    Pilih karpet vinyl standar BWF, parket kayu empuk, atau lapangan reguler. Cek ketersediaan jadwal real-time dan kunci jam mainmu dalam hitungan detik.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#daftar-lapangan" class="btn btn-lime px-4 py-2">
                        Pilih Lapangan <i class="bi bi-arrow-down-short"></i>
                    </a>
                    <?php if (! session()->get('isLoggedIn')) : ?>
                        <a href="<?= base_url('/register') ?>" class="btn btn-outline-light px-4 py-2">
                            Buat Akun Member
                        </a>
                    <?php else : ?>
                        <a href="<?= base_url('/my-bookings') ?>" class="btn btn-outline-light px-4 py-2">
                            Lihat Booking Saya
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Panel Info Kanan -->
            <div class="col-lg-5">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="sh-hero-stat h-100">
                            <div class="font-mono fs-3 fw-bold" style="color: var(--sh-lime);"><?= count($courts) ?></div>
                            <div class="small text-white-50 mt-1">Lapangan Siap Pakai</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="sh-hero-stat h-100">
                            <div class="font-mono fs-3 fw-bold text-white">BWF</div>
                            <div class="small text-white-50 mt-1">Karpet Vinyl Anti-Slip</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="sh-hero-stat d-flex align-items-center justify-content-between">
                            <div>
                                <div class="fw-semibold text-white">Pencahayaan LED Anti-Silau</div>
                                <div class="small text-white-50">Kamar mandi air hangat, parkir luas &amp; kantin</div>
                            </div>
                            <span class="sh-logo-badge ms-3" style="width: 44px; height: 44px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <g transform="rotate(35 12 12)">
                                        <path d="M9 17 L5 5 L9 7 L12 3.5 L15 7 L19 5 L15 17 Z" />
                                        <path d="M10.5 17 L9 7 M13.5 17 L15 7 M12 17 L12 3.8 M7.7 13 H16.3" />
                                        <path d="M9 17 h6 v1.5 a3 3 0 0 1 -6 0 Z" fill="currentColor" />
                                    </g>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Katalog Lapangan -->
<section id="daftar-lapangan" class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 gap-3">
        <div>
            <div class="font-mono small fw-bold text-uppercase" style="color: var(--sh-primary);">Arena Selection</div>
            <h2 class="fw-bold mb-1">Pilihan Lapangan</h2>
            <p class="text-muted mb-0">Filter berdasarkan jenis lantai favorit untuk sesi latihan atau mabar</p>
        </div>

        <!-- Filter Tipe Lantai -->
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= base_url('/') ?>#daftar-lapangan"
               class="sh-filter-btn <?= empty($floorFilter) ? 'active' : '' ?>">
                Semua
            </a>
            <?php foreach ($floors as $floor) : ?>
                <a href="<?= base_url('/?floor=' . urlencode($floor)) ?>#daftar-lapangan"
                   class="sh-filter-btn <?= $floorFilter === $floor ? 'active' : '' ?>">
                    <?= esc($floor) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="row g-4">
        <?php if (empty($courts)) : ?>
            <div class="col-12">
                <div class="card p-5 text-center text-muted">Belum ada lapangan yang tersedia untuk kategori ini.</div>
            </div>
        <?php else : ?>
            <?php foreach ($courts as $court) : ?>
                <div class="col-md-6 col-lg-4">
                    <div class="sh-court-card h-100 d-flex flex-column">
                        <div class="sh-court-media">
                            <?php if (! empty($court['image'])) : ?>
                                <img src="<?= base_url('uploads/courts/' . $court['image']) ?>" alt="<?= esc($court['name']) ?>">
                            <?php else : ?>
                                <div class="sh-court-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="mb-2" style="color: var(--sh-lime);">
                                        <g transform="rotate(35 12 12)">
                                            <path d="M9 17 L5 5 L9 7 L12 3.5 L15 7 L19 5 L15 17 Z" />
                                            <path d="M10.5 17 L9 7 M13.5 17 L15 7 M12 17 L12 3.8 M7.7 13 H16.3" />
                                            <path d="M9 17 h6 v1.5 a3 3 0 0 1 -6 0 Z" fill="currentColor" />
                                        </g>
                                    </svg>
                                    <span class="small fw-semibold text-white"><?= esc($court['name']) ?></span>
                                </div>
                            <?php endif; ?>

                            <div class="position-absolute top-0 start-0 end-0 p-3 d-flex justify-content-between align-items-start">
                                <span class="badge rounded-pill px-3 py-2" style="background: rgba(10,34,31,0.85); color: #fff; backdrop-filter: blur(4px);">
                                    <?= esc($court['floor_type']) ?>
                                </span>
                                <?php if ($court['status'] === 'available') : ?>
                                    <span class="badge rounded-pill px-3 py-2" style="background: var(--sh-lime); color: var(--sh-dark);">
                                        Tersedia
                                    </span>
                                <?php else : ?>
                                    <span class="badge rounded-pill bg-secondary px-3 py-2">Maintenance</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <h5 class="fw-bold mb-2"><?= esc($court['name']) ?></h5>
                            <p class="text-muted small mb-4 flex-grow-1">
                                <?= esc($court['description'] ?: 'Lapangan badminton bersih, terang, dan nyaman.') ?>
                            </p>

                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <div>
                                    <div class="small text-muted" style="font-size: 0.72rem;">Tarif Sewa</div>
                                    <span class="font-mono fw-bold fs-5" style="color: var(--sh-primary);">
                                        Rp <?= number_format($court['price_per_hour'], 0, ',', '.') ?>
                                    </span>
                                    <span class="text-muted small">/jam</span>
                                </div>

                                <?php if ($court['status'] === 'available') : ?>
                                    <a href="<?= base_url('/booking/' . $court['id']) ?>" class="btn btn-primary px-3 py-2">
                                        Booking <i class="bi bi-arrow-right-short"></i>
                                    </a>
                                <?php else : ?>
                                    <button class="btn btn-secondary btn-sm px-3" disabled>Maintenance</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection() ?>