<?php /** @var array $categories */ ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <span class="text-info small fw-bold text-uppercase">Product Management</span>
                <h2 class="fw-bold mb-0">Manajemen Kategori</h2>
            </div>
            <div class="d-flex gap-2">
                <a href="<?= site_url('admin/products') ?>" class="btn btn-outline-cyber btn-sm px-3">
                    <i class="bi bi-box-seam me-1"></i> Kelola Produk
                </a>
                <a href="<?= site_url('admin/categories/create') ?>" class="btn btn-cyber btn-sm px-3">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
                </a>
            </div>
        </div>

        <div class="card-gaming p-3 p-md-4">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr class="text-secondary small text-uppercase">
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Slug</th>
                            <th>Jumlah Produk</th>
                            <th>Deskripsi</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $i => $cat): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td class="fw-semibold">
                                    <i class="bi <?= esc($cat['icon']) ?> text-info me-2"></i>
                                    <?= esc($cat['name']) ?>
                                </td>
                                <td><code class="text-info"><?= esc($cat['slug']) ?></code></td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                                        <?= (int) $cat['product_count'] ?> produk
                                    </span>
                                </td>
                                <td class="small text-secondary"><?= esc($cat['description'] ?: '-') ?></td>
                                <td class="text-end">
                                    <a href="<?= site_url('admin/categories/edit/' . $cat['id_category']) ?>" class="btn btn-outline-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?= site_url('admin/categories/delete/' . $cat['id_category']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($categories)): ?>
                            <tr><td colspan="6" class="text-center text-secondary py-4">Belum ada kategori.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>