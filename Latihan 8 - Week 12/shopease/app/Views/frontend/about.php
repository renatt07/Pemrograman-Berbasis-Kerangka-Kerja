<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <span class="text-info small fw-bold text-uppercase">Tentang ShopEase</span>
                <h1 class="fw-bold mb-3">Dibangun untuk Gamer, Kreator, dan Penggemar Desk Setup.</h1>
                <p class="text-secondary fs-5 mb-4">
                    ShopEase hadir sebagai destinasi perlengkapan gaming berperforma tinggi dengan informasi spesifikasi yang transparan, manajemen stok real-time, serta layanan pengiriman yang terpantau.
                </p>

                <div class="row g-4 mt-2">
                    <div class="col-md-6">
                        <div class="card-gaming p-4 h-100">
                            <h5 class="fw-bold text-info mb-2">Kurasi Produk Ketat</h5>
                            <p class="text-secondary small mb-0">
                                Setiap keyboard, mouse, headset, dan aksesori yang masuk katalog dipilih berdasarkan kualitas build, sensor akurat, dan daya tahan jangka panjang.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-gaming p-4 h-100">
                            <h5 class="fw-bold text-info mb-2">Transaksi Transparan</h5>
                            <p class="text-secondary small mb-0">
                                Mulai dari pengecekan stok, verifikasi pembayaran manual, hingga pelacakan nomor resi pengiriman dapat dipantau langsung melalui akun pelanggan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>