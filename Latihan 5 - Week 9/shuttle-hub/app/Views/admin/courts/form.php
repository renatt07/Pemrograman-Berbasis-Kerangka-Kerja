<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<?php
    $isEdit = ! empty($court);
    $action = $isEdit ? base_url('/admin/courts/update/' . $court['id']) : base_url('/admin/courts/store');
?>

<div class="d-flex justify-content-between align-items-center mt-2 mb-4">
    <h1 class="mb-0"><?= $isEdit ? 'Edit Lapangan' : 'Tambah Lapangan' ?></h1>
    <a href="<?= base_url('/admin/courts') ?>" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="<?= $action ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label fw-semibold">Nama Lapangan</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?= old('name', $court['name'] ?? '') ?>"
                           placeholder="Contoh: Court 5 - Champion Pro" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="floor_type" class="form-label fw-semibold">Tipe Lantai</label>
                    <input type="text" class="form-control" id="floor_type" name="floor_type"
                           value="<?= old('floor_type', $court['floor_type'] ?? '') ?>"
                           placeholder="Contoh: Karpet Vinyl BWF / Parket Kayu" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price_per_hour" class="form-label fw-semibold">Harga per Jam (Rp)</label>
                    <input type="number" class="form-control" id="price_per_hour" name="price_per_hour"
                           value="<?= old('price_per_hour', $court['price_per_hour'] ?? '') ?>"
                           min="1000" step="1000" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <?php $currentStatus = old('status', $court['status'] ?? 'available'); ?>
                    <select class="form-select" id="status" name="status" required>
                        <option value="available" <?= $currentStatus === 'available' ? 'selected' : '' ?>>Tersedia (Available)</option>
                        <option value="maintenance" <?= $currentStatus === 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Deskripsi Fasilitas</label>
                <textarea class="form-control" id="description" name="description" rows="3"
                          placeholder="Tuliskan keunggulan lapangan, pencahayaan, atau fasilitas tambahan"><?= old('description', $court['description'] ?? '') ?></textarea>
            </div>

            <div class="mb-4">
                <label for="image" class="form-label fw-semibold">Foto Lapangan (JPG/PNG/WEBP, maks 2 MB)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <?php if ($isEdit && ! empty($court['image'])) : ?>
                    <div class="mt-2">
                        <small class="text-muted d-block mb-1">Foto saat ini:</small>
                        <img src="<?= base_url('uploads/courts/' . $court['image']) ?>" alt="Preview" class="img-thumbnail" style="max-height: 120px;">
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> <?= $isEdit ? 'Simpan Perubahan' : 'Simpan Lapangan' ?>
            </button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>