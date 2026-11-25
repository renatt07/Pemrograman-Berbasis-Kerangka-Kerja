<?php
/** @var array $products */
?>
<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <div class="font-mono small text-muted">INVENTORY &amp; DROPS</div>
        <h1 class="font-display display-5 fw-bold mb-0">KELOLA PRODUK SEPATU</h1>
    </div>
    <a href="<?= base_url('/admin/products/create') ?>" class="hk-btn hk-btn-accent">+ Tambah Produk</a>
</div>

<div class="table-responsive">
    <table class="table hk-table align-middle mb-0">
        <thead>
            <tr>
                <th style="width: 95px;">Foto</th>
                <th>Produk &amp; SKU</th>
                <th>Kategori / Spec</th>
                <th>Harga</th>
                <th>Stok</th>
                <th style="width: 165px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products)) : ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada produk sepatu.</td></tr>
            <?php else : ?>
                <?php foreach ($products as $p) : ?>
                    <tr>
                        <td>
                            <?php if (! empty($p['image'])) : ?>
                                <img src="<?= base_url('uploads/products/' . $p['image']) ?>" alt="<?= esc($p['name']) ?>" class="border border-dark" style="width: 80px; height: 60px; object-fit: cover;">
                            <?php else : ?>
                                <div class="border border-dark-subtle bg-light text-center font-mono text-muted py-3" style="font-size: 0.65rem;">NO IMG</div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="fw-bold">
                                <?= esc($p['name']) ?>
                                <?php if ($p['is_featured']) : ?>
                                    <span class="hk-tag hk-tag-acid ms-1">HEAT</span>
                                <?php endif; ?>
                            </div>
                            <div class="font-mono text-muted" style="font-size: 0.72rem;">
                                <?= esc($p['brand']) ?> &middot; <?= esc($p['sku']) ?> &middot; <?= esc($p['colorway']) ?>
                            </div>
                        </td>
                        <td>
                            <div class="small fw-semibold"><?= esc($p['category_name']) ?></div>
                            <span class="hk-tag hk-tag-light mt-1"><?= esc($p['court_type']) ?></span>
                        </td>
                        <td class="font-mono small fw-bold">Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                        <td>
                            <span class="hk-tag <?= (int) $p['stock'] <= 5 ? 'hk-tag-accent' : 'hk-tag-dark' ?>">
                                <?= $p['stock'] ?>
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?= base_url('/admin/products/edit/' . $p['id']) ?>" class="hk-btn hk-btn-outline hk-btn-sm">Edit</a>
                                <form action="<?= base_url('/admin/products/delete/' . $p['id']) ?>" method="post" onsubmit="return confirm('Yakin hapus produk ini?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="hk-btn hk-btn-accent hk-btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>