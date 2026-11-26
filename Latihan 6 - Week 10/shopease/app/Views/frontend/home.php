<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="hero-gaming py-5">
    <div class="container py-lg-5">
        <div class="row align-items-center gy-5">
            <div class="col-lg-6">
                <span class="hero-badge mb-3">
                    <i class="bi bi-lightning-charge-fill"></i>
                    NEXT-GEN ESPORTS & DESK SETUP
                </span>
                <h1 class="display-4 fw-bold lh-sm mb-3 hero-title-gradient">
                    Upgrade Setup Kamu. Dominasi Setiap Match.
                </h1>
                <p class="text-secondary fs-5 mb-4">
                    Koleksi kurasi mechanical keyboard, mouse ultralight, headset low-latency, dan aksesori meja pilihan pro player dengan garansi resmi.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?= site_url('catalog') ?>" class="btn btn-cyber btn-lg px-4">
                        Jelajahi Katalog <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <a href="<?= site_url('catalog?category=mechanical-keyboard') ?>" class="btn btn-outline-cyber btn-lg px-4">
                        Keyboard Custom
                    </a>
                </div>

                <div class="row g-3 mt-4 pt-3 border-top border-secondary border-opacity-25">
                    <div class="col-4">
                        <div class="brand-font fs-4 fw-bold text-white">100%</div>
                        <div class="small text-secondary">Produk Original</div>
                    </div>
                    <div class="col-4">
                        <div class="brand-font fs-4 fw-bold text-info">24 Jam</div>
                        <div class="small text-secondary">Proses Cepat</div>
                    </div>
                    <div class="col-4">
                        <div class="brand-font fs-4 fw-bold text-white">2 Tahun</div>
                        <div class="small text-secondary">Garansi Resmi</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <?php $heroProduct = $featuredProducts[1]; ?>
                <div class="card-gaming p-3">
                    <div class="product-img-wrap rounded-3">
                        <img src="<?= esc($heroProduct['image']) ?>"
                             alt="<?= esc($heroProduct['name']) ?>"
                             class="img-fluid rounded-3 w-100">
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3 px-2">
                        <div>
                            <div class="small text-info fw-semibold">FEATURED PRO SERIES</div>
                            <div class="fw-bold"><?= esc($heroProduct['name']) ?></div>
                        </div>
                        <a href="<?= site_url('product/' . $heroProduct['id']) ?>" class="btn btn-outline-cyber btn-sm">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Kategori -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-info small fw-bold text-uppercase">Kategori Gear</span>
                <h2 class="fw-bold mb-0">Pilih Senjata Favoritmu</h2>
            </div>
            <a href="<?= site_url('catalog') ?>" class="text-info text-decoration-none small fw-semibold">
                Semua Kategori <i class="bi bi-chevron-right"></i>
            </a>
        </div>

        <div class="row g-4">
            <?php foreach ($categories as $cat): ?>
                <div class="col-sm-6 col-lg-3">
                    <a href="<?= site_url('catalog?category=' . urlencode($cat['slug'])) ?>" class="category-tile">
                        <div class="category-icon mb-3">
                            <i class="bi <?= esc($cat['icon']) ?>"></i>
                        </div>
                        <h5 class="fw-bold mb-2"><?= esc($cat['name']) ?></h5>
                        <p class="text-secondary small mb-0"><?= esc($cat['description']) ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Produk Unggulan -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-info small fw-bold text-uppercase">Best Seller</span>
                <h2 class="fw-bold mb-0">Produk Unggulan</h2>
            </div>
            <a href="<?= site_url('catalog') ?>" class="btn btn-outline-cyber btn-sm">Lihat Semua</a>
        </div>

        <div class="row g-4">
            <?php foreach ($featuredProducts as $p): ?>
                <div class="col-sm-6 col-lg-3">
                    <div class="card-gaming h-100 d-flex flex-column">
                        <div class="product-img-wrap">
                            <span class="product-badge"><?= esc($p['badge']) ?></span>
                            <img src="<?= esc($p['image']) ?>" alt="<?= esc($p['name']) ?>">
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <div class="small text-secondary mb-1"><?= esc($p['category_name']) ?></div>
                            <h6 class="fw-bold mb-2"><?= esc($p['name']) ?></h6>
                            <div class="mt-auto pt-2">
                                <div class="price-tag mb-3">Rp <?= number_format($p['price'], 0, ',', '.') ?></div>
                                <div class="d-grid">
                                    <a href="<?= site_url('product/' . $p['id']) ?>" class="btn btn-outline-cyber btn-sm">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Rilis Terbaru -->
<section class="py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="text-info small fw-bold text-uppercase">New Arrivals</span>
                <h2 class="fw-bold mb-0">Rilis Terbaru</h2>
            </div>
            <a href="<?= site_url('catalog') ?>" class="text-info text-decoration-none small fw-semibold">
                Lihat Katalog <i class="bi bi-chevron-right"></i>
            </a>
        </div>

        <div class="row g-4">
            <?php foreach ($latestProducts as $p): ?>
                <div class="col-sm-6 col-lg-3">
                    <div class="card-gaming h-100 d-flex flex-column">
                        <div class="product-img-wrap">
                            <span class="product-badge <?= $p['stock'] === 0 ? 'border-secondary text-secondary' : '' ?>">
                                <?= esc($p['badge']) ?>
                            </span>
                            <img src="<?= esc($p['image']) ?>" alt="<?= esc($p['name']) ?>">
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <div class="small text-secondary mb-1"><?= esc($p['category_name']) ?></div>
                            <h6 class="fw-bold mb-2"><?= esc($p['name']) ?></h6>
                            <div class="mt-auto pt-2">
                                <div class="price-tag mb-3">Rp <?= number_format($p['price'], 0, ',', '.') ?></div>
                                <div class="d-grid">
                                    <a href="<?= site_url('product/' . $p['id']) ?>" class="btn btn-outline-cyber btn-sm">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Keunggulan Toko -->
<section class="py-5">
    <div class="container">
        <div class="card-gaming p-4 p-lg-5">
            <div class="row g-4 text-center text-md-start">
                <div class="col-md-4">
                    <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-3">
                        <div class="category-icon flex-shrink-0"><i class="bi bi-shield-check"></i></div>
                        <div>
                            <h5 class="fw-bold mb-1">Garansi Resmi & Original</h5>
                            <p class="text-secondary small mb-0">Setiap unit diverifikasi keasliannya dan dilindungi garansi penggantian resmi.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-3">
                        <div class="category-icon flex-shrink-0"><i class="bi bi-box-seam"></i></div>
                        <div>
                            <h5 class="fw-bold mb-1">Packing Aman + Resi Jelas</h5>
                            <p class="text-secondary small mb-0">Double bubble wrap dan pelacakan nomor resi langsung dari halaman pesanan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-3">
                        <div class="category-icon flex-shrink-0"><i class="bi bi-headset"></i></div>
                        <div>
                            <h5 class="fw-bold mb-1">Konsultasi Setup</h5>
                            <p class="text-secondary small mb-0">Bingung pilih switch keyboard atau bentuk mouse? Tim kami siap bantu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>