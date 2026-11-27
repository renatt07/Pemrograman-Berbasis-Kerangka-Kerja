<?php /** @var array $items @var float $subtotal */ ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="mb-4">
            <span class="text-info small fw-bold text-uppercase">Shopping Cart</span>
            <h1 class="fw-bold mb-0">Keranjang Belanja</h1>
        </div>

        <?php if (empty($items)): ?>
            <div class="card-gaming p-5 text-center">
                <i class="bi bi-cart-x fs-1 text-secondary d-block mb-3"></i>
                <h4 class="fw-bold">Keranjang masih kosong</h4>
                <p class="text-secondary mb-4">Yuk pilih gaming gear favoritmu dari katalog kami.</p>
                <a href="<?= site_url('catalog') ?>" class="btn btn-cyber px-4">Mulai Belanja</a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card-gaming p-3 p-md-4">
                        <div class="table-responsive">
                            <table class="table table-dark align-middle mb-0">
                                <thead>
                                    <tr class="text-secondary small text-uppercase">
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th style="width: 150px;">Jumlah</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="<?= esc($item['image_url']) ?>" alt="<?= esc($item['name']) ?>"
                                                         style="width: 60px; height: 45px; object-fit: contain; background: #0d1321; border-radius: 6px; padding: 4px;">
                                                    <div>
                                                        <a href="<?= site_url('product/' . $item['id_product']) ?>" class="text-white text-decoration-none fw-semibold">
                                                            <?= esc($item['name']) ?>
                                                        </a>
                                                        <div class="small text-secondary">Stok: <?= (int) $item['stock'] ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="small">Rp <?= number_format((float) $item['price'], 0, ',', '.') ?></td>
                                            <td>
                                                <form action="<?= site_url('cart/update/' . $item['id_cart_item']) ?>" method="POST" class="d-flex gap-1">
                                                    <?= csrf_field() ?>
                                                    <input type="number" name="quantity" class="form-control form-control-sm text-center"
                                                           value="<?= (int) $item['quantity'] ?>" min="1" max="<?= max(1, (int) $item['stock']) ?>">
                                                    <button type="submit" class="btn btn-outline-cyber btn-sm" title="Perbarui">
                                                        <i class="bi bi-check2"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="brand-font text-info fw-bold">
                                                Rp <?= number_format((float) $item['line_subtotal'], 0, ',', '.') ?>
                                            </td>
                                            <td class="text-end">
                                                <form action="<?= site_url('cart/remove/' . $item['id_cart_item']) ?>" method="POST">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card-gaming p-4">
                        <h5 class="fw-bold mb-3">Ringkasan Belanja</h5>
                        <div class="d-flex justify-content-between mb-2 small text-secondary">
                            <span>Subtotal Produk</span>
                            <span class="text-white">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 small text-secondary">
                            <span>Ongkos Kirim</span>
                            <span>Dihitung saat checkout</span>
                        </div>
                        <hr class="border-secondary opacity-25">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold">Estimasi Total</span>
                            <span class="brand-font fs-4 fw-bold text-info">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="<?= site_url('checkout') ?>" class="btn btn-cyber btn-lg">
                                Lanjut ke Checkout <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                            <a href="<?= site_url('catalog') ?>" class="btn btn-outline-secondary btn-sm">
                                Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection() ?>