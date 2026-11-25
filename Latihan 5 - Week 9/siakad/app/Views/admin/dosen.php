<?php
/**
 * @var array      $dosenList
 * @var array      $prodiList
 * @var array|null $edit
 */
$isEdit = ! empty($edit);
$action = $isEdit ? base_url('/admin/dosen/update/' . $edit['id']) : base_url('/admin/dosen/store');
?>
<?= $this->extend('layout/siakad') ?>

<?= $this->section('content') ?>
<h2 class="fw-bold mb-4">Kelola Data Dosen</h2>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">
                <?= $isEdit ? 'Edit Data Dosen' : 'Tambah Dosen Baru' ?>
            </div>
            <div class="card-body">
                <form action="<?= $action ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">NIP</label>
                        <input type="text" name="nip" class="form-control" value="<?= old('nip', $edit['nip'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Lengkap &amp; Gelar</label>
                        <input type="text" name="nama" class="form-control" value="<?= old('nama', $edit['nama'] ?? '') ?>" required>
                    </div>
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
                        <label class="form-label small fw-semibold">Email Login</label>
                        <input type="email" name="email" class="form-control" value="<?= old('email', $edit['email'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">
                            Password <?= $isEdit ? '<span class="text-muted fw-normal">(kosongkan jika tetap)</span>' : '' ?>
                        </label>
                        <input type="password" name="password" class="form-control" <?= $isEdit ? '' : 'required' ?>>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Simpan Perubahan' : 'Tambah Dosen' ?></button>
                        <?php if ($isEdit) : ?>
                            <a href="<?= base_url('/admin/dosen') ?>" class="btn btn-secondary">Batal</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Daftar Dosen</div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>NIP</th>
                            <th>Nama &amp; Email</th>
                            <th>Program Studi</th>
                            <th style="width: 130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dosenList as $d) : ?>
                            <tr>
                                <td><code><?= esc($d['nip']) ?></code></td>
                                <td>
                                    <div class="fw-semibold"><?= esc($d['nama']) ?></div>
                                    <small class="text-muted"><?= esc($d['email']) ?></small>
                                </td>
                                <td><?= esc($d['nama_prodi']) ?></td>
                                <td>
                                    <a href="<?= base_url('/admin/dosen/edit/' . $d['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="<?= base_url('/admin/dosen/delete/' . $d['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus dosen ini?')">
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