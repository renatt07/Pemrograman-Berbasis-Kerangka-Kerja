<?php
/**
 * @var array      $categories
 * @var array|null $edit
 */
$isEdit = ! empty($edit);
$action = $isEdit ? base_url('/admin/categories/update/' . $edit['id']) : base_url('/admin/categories/store');
?>
<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h1 class="font-display display-5 fw-bold mb-4">KELOLA KATEGORI</h1>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="hk-card p-4">
            <h4 class="font-display fs-3 fw-bold mb-3"><?= $isEdit ? 'EDIT KATEGORI' : 'TAMBAH KATEGORI' ?></h4>
            <form action="<?= $action ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label font-mono small fw-bold text-uppercase">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" value="<?= old('name', $edit['name'] ?? '') ?>" placeholder="Contoh: Forward / High-Top" required>
                </div>
                <div class="mb-4">
                    <label class="form-label font-mono small fw-bold text-uppercase">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Penjelasan singkat kategori"><?= old('description', $edit['description'] ?? '') ?></textarea>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="hk-btn hk-btn-dark"><?= $isEdit ? 'Simpan Perubahan' : 'Tambah Kategori' ?></button>
                    <?php if ($isEdit) : ?>
                        <a href="<?= base_url('/admin/categories') ?>" class="hk-btn hk-btn-outline">Batal</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="table-responsive">
            <table class="table hk-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nama &amp; Slug</th>
                        <th>Produk</th>
                        <th style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat) : ?>
                        <tr>
                            <td>
                                <div class="fw-bold"><?= esc($cat['name']) ?></div>
                                <div class="font-mono text-muted" style="font-size: 0.72rem;">/<?= esc($cat['slug']) ?></div>
                                <div class="small text-muted mt-1"><?= esc($cat['description'] ?: '-') ?></div>
                            </td>
                            <td><span class="hk-tag hk-tag-acid"><?= $cat['product_count'] ?> PAIR</span></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?= base_url('/admin/categories/edit/' . $cat['id']) ?>" class="hk-btn hk-btn-outline hk-btn-sm">Edit</a>
                                    <form action="<?= base_url('/admin/categories/delete/' . $cat['id']) ?>" method="post" onsubmit="return confirm('Hapus kategori ini beserta produk di dalamnya?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="hk-btn hk-btn-accent hk-btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>