<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="<?= site_url('/') ?>" class="text-secondary text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('catalog') ?>" class="text-secondary text-decoration-none">Katalog</a></li>
                <li class="breadcrumb-item active text-info" aria-current="page"><?= esc($product['name']) ?></li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- Galeri Foto -->
            <div class="col-lg-6">
                <div class="card-gaming p-2 mb-3">
                    <div class="product-img-wrap rounded-3">
                        <img id="mainProductImage"
                            src="<?= esc($product['gallery'][0] ?? $product['image']) ?>"
                            alt="<?= esc($product['name']) ?>">
                    </div>
                </div>
                <?php if (count($product['gallery']) > 1): ?>
                    <div class="row g-2">
                        <?php foreach ($product['gallery'] as $index => $imgUrl): ?>
                            <div class="col-3">
                                <img src="<?= esc($imgUrl) ?>"
                                     alt="Thumbnail <?= $index + 1 ?>"
                                     class="img-fluid thumb-img <?= $index === 0 ? 'active' : '' ?>"
                                     onclick="switchProductImage(this, '<?= esc($imgUrl, 'js') ?>')">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Info & Spesifikasi -->
            <div class="col-lg-6">
                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 mb-2 px-3 py-2">
                    <?= esc($product['category_name']) ?>
                </span>
                <h1 class="fw-bold mb-2"><?= esc($product['name']) ?></h1>

                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="brand-font fs-2 fw-bold text-info">
                        Rp <?= number_format($product['price'], 0, ',', '.') ?>
                    </div>
                    <?php if ($product['stock'] > 0): ?>
                        <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50">
                            Tersedia (<?= $product['stock'] ?> unit)
                        </span>
                    <?php else: ?>
                        <span class="badge bg-danger bg-opacity-25 text-danger border border-danger border-opacity-50">
                            Stok Habis
                        </span>
                    <?php endif; ?>
                </div>

                <p class="text-secondary mb-4"><?= esc($product['description']) ?></p>

                <div class="card-gaming p-3 mb-4">
                    <h6 class="brand-font text-uppercase small text-info mb-3">Spesifikasi Utama</h6>
                    <div class="table-responsive">
                        <table class="table table-dark table-sm mb-0 align-middle">
                            <tbody>
                                <?php foreach ($product['specs'] as $label => $value): ?>
                                    <tr>
                                        <td class="text-secondary border-secondary border-opacity-25" style="width: 38%;"><?= esc($label) ?></td>
                                        <td class="fw-semibold border-secondary border-opacity-25"><?= esc($value) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row g-3 align-items-center">
                    <div class="col-4 col-sm-3">
                        <label class="form-label small text-secondary mb-1">Jumlah</label>
                        <input type="number" class="form-control text-center" value="1" min="1" max="<?= max(1, $product['stock']) ?>" <?= $product['stock'] === 0 ? 'disabled' : '' ?>>
                    </div>
                    <div class="col-8 col-sm-9 pt-4">
                        <button type="button"
                                class="btn btn-cyber btn-lg w-100"
                                <?= $product['stock'] === 0 ? 'disabled' : '' ?>
                                data-bs-toggle="modal"
                                data-bs-target="#comingSoonModal"
                                data-feature="Tambah ke Keranjang (Week 12)">
                            <i class="bi bi-cart-plus me-2"></i>
                            <?= $product['stock'] > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produk Lainnya -->
        <div class="mt-5 pt-4 border-top border-secondary border-opacity-25">
            <h4 class="fw-bold mb-4">Gear Lainnya untuk Setup Kamu</h4>
            <div class="row g-4">
                <?php foreach ($relatedProducts as $rel): ?>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card-gaming h-100 d-flex flex-column">
                            <div class="product-img-wrap">
                                <img src="<?= esc($rel['image']) ?>" alt="<?= esc($rel['name']) ?>">
                            </div>
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <div class="small text-secondary mb-1"><?= esc($rel['category_name']) ?></div>
                                <h6 class="fw-bold mb-2"><?= esc($rel['name']) ?></h6>
                                <div class="mt-auto">
                                    <div class="price-tag mb-2">Rp <?= number_format($rel['price'], 0, ',', '.') ?></div>
                                    <a href="<?= site_url('product/' . $rel['id']) ?>" class="btn btn-outline-cyber btn-sm w-100">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function switchProductImage(el, url) {
        document.getElementById('mainProductImage').src = url;
        document.querySelectorAll('.thumb-img').forEach(img => img.classList.remove('active'));
        el.classList.add('active');
    }
</script>
<?= $this->endSection() ?>