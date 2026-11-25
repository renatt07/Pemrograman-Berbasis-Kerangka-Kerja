<?php
/**
 * @var array      $prodiList
 * @var array|null $edit
 */
$isEdit = ! empty($edit);
$action = $isEdit ? base_url('/admin/prodi/update/' . $edit['id']) : base_url('/admin/prodi/store');
?>
<?= $this->extend('layout/siakad') ?>

<?= $this->section('content') ?>
<h2 class="fw-bold mb-4">Kelola Program Studi</h2>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">
                <?= $isEdit ? 'Edit Program Studi' : 'Tambah Program Studi' ?>
            </div>
            <div class="card-body">
                <form action="<?= $action ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Kode Prodi</label>
                        <input type="text" name="kode_prodi" class="form-control" value="<?= old('kode_prodi', $edit['kode_prodi'] ?? '') ?>" placeholder="Contoh: TI" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Program Studi</label>
                        <input type="text" name="nama_prodi" class="form-control" value="<?= old('nama_prodi', $edit['nama_prodi'] ?? '') ?>" placeholder="Contoh: Teknologi Informasi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Fakultas</label>
                        <input type="text" name="fakultas" class="form-control" value="<?= old('fakultas', $edit['fakultas'] ?? '') ?>" placeholder="Contoh: FTEIC" required>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Simpan Perubahan' : 'Tambah Prodi' ?></button>
                        <?php if ($isEdit) : ?>
                            <a href="<?= base_url('/admin/prodi') ?>" class="btn btn-secondary">Batal</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Daftar Program Studi</div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Nama Program Studi</th>
                            <th>Fakultas</th>
                            <th style="width: 130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($prodiList as $p) : ?>
                            <tr>
                                <td><span class="badge bg-primary"><?= esc($p['kode_prodi']) ?></span></td>
                                <td class="fw-semibold"><?= esc($p['nama_prodi']) ?></td>
                                <td><?= esc($p['fakultas']) ?></td>
                                <td>
                                    <a href="<?= base_url('/admin/prodi/edit/' . $p['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="<?= base_url('/admin/prodi/delete/' . $p['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Hapus prodi ini? Data terkait ikut terhapus.')">
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