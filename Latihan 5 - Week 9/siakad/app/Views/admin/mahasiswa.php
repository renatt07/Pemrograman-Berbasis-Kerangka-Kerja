<?php
/**
 * @var array      $mhsList
 * @var array      $prodiList
 * @var array      $dosenList
 * @var array|null $edit
 */
$isEdit = ! empty($edit);
$action = $isEdit ? base_url('/admin/mahasiswa/update/' . $edit['id']) : base_url('/admin/mahasiswa/store');
?>
<?= $this->extend('layout/siakad') ?>

<?= $this->section('content') ?>
<h2 class="fw-bold mb-4">Kelola Data Mahasiswa &amp; Dosen Wali</h2>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">
                <?= $isEdit ? 'Edit Data Mahasiswa' : 'Tambah Mahasiswa Baru' ?>
            </div>
            <div class="card-body">
                <form action="<?= $action ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">NRP</label>
                        <input type="text" name="nrp" class="form-control form-control-sm" value="<?= old('nrp', $edit['nrp'] ?? '') ?>" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control form-control-sm" value="<?= old('nama', $edit['nama'] ?? '') ?>" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Program Studi</label>
                        <?php $selProdi = (int) old('prodi_id', $edit['prodi_id'] ?? 0); ?>
                        <select name="prodi_id" class="form-select form-select-sm" required>
                            <option value="">-- Pilih Prodi --</option>
                            <?php foreach ($prodiList as $p) : ?>
                                <option value="<?= $p['id'] ?>" <?= $selProdi === (int) $p['id'] ? 'selected' : '' ?>>
                                    <?= esc($p['nama_prodi']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Dosen Wali</label>
                        <?php $selWali = (int) old('dosen_wali_id', $edit['dosen_wali_id'] ?? 0); ?>
                        <select name="dosen_wali_id" class="form-select form-select-sm">
                            <option value="">-- Belum Ditentukan --</option>
                            <?php foreach ($dosenList as $d) : ?>
                                <option value="<?= $d['id'] ?>" <?= $selWali === (int) $d['id'] ? 'selected' : '' ?>>
                                    <?= esc($d['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-4">
                            <label class="form-label small fw-semibold">Angkatan</label>
                            <input type="number" name="angkatan" class="form-control form-control-sm" value="<?= old('angkatan', $edit['angkatan'] ?? 2024) ?>" required>
                        </div>
                        <div class="col-4">
                            <label class="form-label small fw-semibold">Semester</label>
                            <input type="number" name="semester_aktif" class="form-control form-control-sm" value="<?= old('semester_aktif', $edit['semester_aktif'] ?? 1) ?>" min="1" max="14" required>
                        </div>
                        <div class="col-4">
                            <label class="form-label small fw-semibold">Batas SKS</label>
                            <input type="number" name="batas_sks" class="form-control form-control-sm" value="<?= old('batas_sks', $edit['batas_sks'] ?? 24) ?>" min="12" max="24" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Email Login</label>
                        <input type="email" name="email" class="form-control form-control-sm" value="<?= old('email', $edit['email'] ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">
                            Password <?= $isEdit ? '<span class="text-muted fw-normal">(opsional)</span>' : '' ?>
                        </label>
                        <input type="password" name="password" class="form-control form-control-sm" <?= $isEdit ? '' : 'required' ?>>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm"><?= $isEdit ? 'Simpan Perubahan' : 'Tambah Mahasiswa' ?></button>
                        <?php if ($isEdit) : ?>
                            <a href="<?= base_url('/admin/mahasiswa') ?>" class="btn btn-secondary btn-sm">Batal</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Daftar Mahasiswa</div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>NRP &amp; Nama</th>
                            <th>Prodi</th>
                            <th>Dosen Wali</th>
                            <th>Smt / SKS</th>
                            <th style="width: 130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mhsList as $m) : ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold"><?= esc($m['nama']) ?></div>
                                    <small class="text-muted"><?= esc($m['nrp']) ?> &middot; <?= esc($m['email']) ?></small>
                                </td>
                                <td>
                                    <div><?= esc($m['nama_prodi']) ?></div>
                                    <small class="text-muted">Angkatan <?= esc($m['angkatan']) ?></small>
                                </td>
                                <td><?= esc($m['nama_dosen_wali'] ?? '-') ?></td>
                                <td><span class="badge bg-info text-dark">Smt <?= $m['semester_aktif'] ?></span> / <?= $m['batas_sks'] ?> SKS</td>
                                <td>
                                    <a href="<?= base_url('/admin/mahasiswa/edit/' . $m['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="<?= base_url('/admin/mahasiswa/delete/' . $m['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus mahasiswa ini?')">
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