<?php
/**
 * @var array      $mkList
 * @var array      $prodiList
 * @var array|null $edit
 */
$isEdit = ! empty($edit);
$action = $isEdit ? base_url('/admin/matakuliah/update/' . $edit['id']) : base_url('/admin/matakuliah/store');
?>
<?= $this->extend('layout/siakad') ?>

<?= $this->section('content') ?>
<h2 class="fw-bold mb-4">Kelola Mata Kuliah</h2>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">
                <?= $isEdit ? 'Edit Mata Kuliah' : 'Tambah Mata Kuliah' ?>
            </div>
            <div class="card-body">
                <form action="<?= $action ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Program Studi</label>
                        <?php $selProdi = (int) old('prodi_id', $edit['prodi_id'] ?? 0); ?>
                        <select name="prodi_id" class="form-select" required>
                            <option value="">-- Pilih Prodi --</option>
                            <?php foreach ($prodiList as $p) : ?>
                                <option value="<?= $p['id'] ?>" <?= $selProdi === (int) $p['id'] ? 'selected' : '' ?>>
                                    <?= esc($p['nama_prodi']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Kode MK</label>
                        <input type="text" name="kode_mk" class="form-control" value="<?= old('kode_mk', $edit['kode_mk'] ?? '') ?>" placeholder="Contoh: IF401" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Mata Kuliah</label>
                        <input type="text" name="nama_mk" class="form-control" value="<?= old('nama_mk', $edit['nama_mk'] ?? '') ?>" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">SKS</label>
                            <input type="number" name="sks" class="form-control" value="<?= old('sks', $edit['sks'] ?? 3) ?>" min="1" max="6" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Semester</label>
                            <input type="number" name="semester" class="form-control" value="<?= old('semester', $edit['semester'] ?? 1) ?>" min="1" max="8" required>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Simpan Perubahan' : 'Tambah MK' ?></button>
                        <?php if ($isEdit) : ?>
                            <a href="<?= base_url('/admin/matakuliah') ?>" class="btn btn-secondary">Batal</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Daftar Mata Kuliah</div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Nama Mata Kuliah</th>
                            <th>Prodi</th>
                            <th>SKS / Smt</th>
                            <th style="width: 130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mkList as $mk) : ?>
                            <tr>
                                <td><span class="badge bg-dark"><?= esc($mk['kode_mk']) ?></span></td>
                                <td class="fw-semibold"><?= esc($mk['nama_mk']) ?></td>
                                <td><?= esc($mk['nama_prodi']) ?></td>
                                <td><?= $mk['sks'] ?> SKS &middot; Smt <?= $mk['semester'] ?></td>
                                <td>
                                    <a href="<?= base_url('/admin/matakuliah/edit/' . $mk['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="<?= base_url('/admin/matakuliah/delete/' . $mk['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus mata kuliah ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>