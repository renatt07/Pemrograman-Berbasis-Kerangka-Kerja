<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <span class="text-info small fw-bold text-uppercase">Hubungi Kami</span>
                <h1 class="fw-bold mb-3">Butuh Rekomendasi Gear?</h1>
                <p class="text-secondary mb-4">
                    Kirimkan pertanyaan seputar kecocokan switch, garansi produk, atau pesanan melalui formulir di samping.
                </p>
                <div class="d-grid gap-3">
                    <div class="card-gaming p-3 d-flex align-items-center gap-3">
                        <div class="category-icon"><i class="bi bi-geo-alt"></i></div>
                        <div>
                            <div class="small text-secondary">Alamat Showroom</div>
                            <div class="fw-semibold">Jl. Teknologi Raya No. 88, Surabaya</div>
                        </div>
                    </div>
                    <div class="card-gaming p-3 d-flex align-items-center gap-3">
                        <div class="category-icon"><i class="bi bi-envelope"></i></div>
                        <div>
                            <div class="small text-secondary">Email Support</div>
                            <div class="fw-semibold">support@shopease-gear.local</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card-gaming p-4 p-md-5">
                    <h4 class="fw-bold mb-4">Kirim Pesan</h4>
                    <form onsubmit="event.preventDefault(); alert('Terima kasih! Pesan demo berhasil disimulasikan.');">
                        <div class="mb-3">
                            <label class="form-label small text-secondary">Nama Lengkap</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-secondary">Email</label>
                            <input type="email" class="form-control" placeholder="nama@email.com" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small text-secondary">Pesan</label>
                            <textarea class="form-control" rows="4" placeholder="Tulis pertanyaan Anda..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-cyber px-4">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>