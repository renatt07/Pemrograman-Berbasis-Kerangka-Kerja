<?php /** @var array $products @var array $categories @var string $keyword @var string $selectedCat */ ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <span class="text-info small fw-bold text-uppercase">Product Management</span>
                <h2 class="fw-bold mb-0">Manajemen Produk</h2>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= site_url('admin/categories') ?>" class="btn btn-outline-cyber btn-sm px-3">
                    <i class="bi bi-tags me-1"></i> Kelola Kategori
                </a>
                <a href="<?= site_url('admin/products/create') ?>" class="btn btn-cyber btn-sm px-3">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Produk
                </a>
            </div>
        </div>

        <!-- Filter & Pencarian Admin -->
        <form action="<?= site_url('admin/products') ?>" method="GET" class="card-gaming p-3 mb-4">
            <div class="row g-2 align-items-end">
                <div class="col-md-5">
                    <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari nama produk..." value="<?= esc($keyword) ?>">
                </div>
                <div class="col-md-4">
                    <select name="category" class="form-select form-select-sm">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id_category'] ?>" <?= (string) $selectedCat === (string) $cat['id_category'] ? 'selected' : '' ?>>
                                <?= esc($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-cyber btn-sm w-100">Filter</button>
                    <a href="<?= site_url('admin/products') ?>" class="btn btn-outline-secondary btn-sm">Reset</a>
                </div>
            </div>
        </form>

        <div class="card-gaming p-3 p-md-4">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr class="text-secondary small text-uppercase">
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="<?= esc($p['image_url']) ?>" alt="<?= esc($p['name']) ?>"
                                             style="width: 56px; height: 42px; object-fit: contain; background: #0d1321; border-radius: 6px; padding: 4px;">
                                        <div>
                                            <div class="fw-semibold"><?= esc($p['name']) ?></div>
                                            <?php if (!empty($p['badge'])): ?>
                                                <span class="badge bg-info bg-opacity-10 text-info" style="font-size: 0.7rem;"><?= esc($p['badge']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="small text-secondary"><?= esc($p['category_name']) ?></td>
                                <td class="brand-font text-info fw-semibold">Rp <?= number_format((float) $p['price'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if ((int) $p['stock'] === 0): ?>
                                        <span class="badge bg-danger">Habis (0)</span>
                                    <?php elseif ((int) $p['stock'] <= 5): ?>
                                        <span class="badge bg-warning text-dark">Menipis (<?= (int) $p['stock'] ?>)</span>
                                    <?php else: ?>
                                        <span class="badge bg-success bg-opacity-25 text-success"><?= (int) $p['stock'] ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($p['status'] === 'tersedia'): ?>
                                        <span class="badge bg-success">Tersedia</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Tidak Tersedia</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?= site_url('admin/products/edit/' . $p['id_product']) ?>" class="btn btn-outline-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?= site_url('admin/products/delete/' . $p['id_product']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus produk ini beserta fotonya?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($products)): ?>
                            <tr><td colspan="6" class="text-center text-secondary py-4">Belum ada data produk.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>