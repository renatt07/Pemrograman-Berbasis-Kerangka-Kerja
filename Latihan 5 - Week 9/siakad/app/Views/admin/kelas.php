<?php
/**
 * @var array      $kelasList
 * @var array      $mkList
 * @var array      $dosenList
 * @var array|null $edit
 */
$isEdit = ! empty($edit);
$action = $isEdit ? base_url('/admin/kelas/update/' . $edit['id']) : base_url('/admin/kelas/store');
?>
<?= $this->extend('layout/siakad') ?>

<?= $this->section('content') ?>
<h2 class="fw-bold mb-4">Kelola Kelas Perkuliahan</h2>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">
                <?= $isEdit ? 'Edit Kelas & Kuota' : 'Buka Kelas Baru' ?>
            </div>
            <div class="card-body">
                <form action="<?= $action ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Mata Kuliah</label>
                        <?php $selMk = (int) old('mata_kuliah_id', $edit['mata_kuliah_id'] ?? 0); ?>
                        <select name="mata_kuliah_id" class="form-select form-select-sm" required>
                            <option value="">-- Pilih Mata Kuliah --</option>
                            <?php foreach ($mkList as $mk) : ?>
                                <option value="<?= $mk['id'] ?>" <?= $selMk === (int) $mk['id'] ? 'selected' : '' ?>>
                                    <?= esc($mk['kode_mk']) ?> — <?= esc($mk['nama_mk']) ?> (<?= $mk['sks'] ?> SKS)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Dosen Pengampu</label>
                        <?php $selDosen = (int) old('dosen_id', $edit['dosen_id'] ?? 0); ?>
                        <select name="dosen_id" class="form-select form-select-sm" required>
                            <option value="">-- Pilih Dosen --</option>
                            <?php foreach ($dosenList as $d) : ?>
                                <option value="<?= $d['id'] ?>" <?= $selDosen === (int) $d['id'] ? 'selected' : '' ?>>
                                    <?= esc($d['nama']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Nama Kelas</label>
                            <input type="text" name="nama_kelas" class="form-control form-control-sm" value="<?= old('nama_kelas', $edit['nama_kelas'] ?? '') ?>" placeholder="A / B / D" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Kuota</label>
                            <input type="number" name="kuota" class="form-control form-control-sm" value="<?= old('kuota', $edit['kuota'] ?? 40) ?>" min="5" max="200" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" class="form-control form-control-sm" value="<?= old('tahun_ajaran', $edit['tahun_ajaran'] ?? '2026/2027 Ganjil') ?>" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Jadwal</label>
                        <input type="text" name="jadwal" class="form-control form-control-sm" value="<?= old('jadwal', $edit['jadwal'] ?? '') ?>" placeholder="Senin, 08:00 - 10:30" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Ruangan</label>
                        <input type="text" name="ruangan" class="form-control form-control-sm" value="<?= old('ruangan', $edit['ruangan'] ?? '') ?>" placeholder="IF-105" required>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm"><?= $isEdit ? 'Simpan Perubahan' : 'Buka Kelas' ?></button>
                        <?php if ($isEdit) : ?>
                            <a href="<?= base_url('/admin/kelas') ?>" class="btn btn-secondary btn-sm">Batal</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Daftar Kelas</div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Mata Kuliah &amp; Kelas</th>
                            <th>Dosen</th>
                            <th>Jadwal</th>
                            <th>Kuota</th>
                            <th style="width: 130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kelasList as $k) : ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold"><?= esc($k['kode_mk']) ?> — <?= esc($k['nama_mk']) ?> <span class="badge bg-primary"><?= esc($k['nama_kelas']) ?></span></div>
                                    <small class="text-muted"><?= esc($k['tahun_ajaran']) ?></small>
                                </td>
                                <td><?= esc($k['nama_dosen']) ?></td>
                                <td>
                                    <div><?= esc($k['jadwal']) ?></div>
                                    <small class="text-muted"><?= esc($k['ruangan']) ?></small>
                                </td>
                                <td><span class="badge bg-secondary"><?= $k['terisi'] ?> / <?= $k['kuota'] ?></span></td>
                                <td>
                                    <a href="<?= base_url('/admin/kelas/edit/' . $k['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="<?= base_url('/admin/kelas/delete/' . $k['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus kelas ini?')">
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