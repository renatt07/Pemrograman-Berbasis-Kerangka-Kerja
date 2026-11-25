<?php
/**
 * @var int   $totalProdi
 * @var int   $totalDosen
 * @var int   $totalMahasiswa
 * @var int   $totalMatkul
 * @var int   $totalKelas
 * @var array $kelasList
 */
?>
<?= $this->extend('layout/siakad') ?>

<?= $this->section('content') ?>
<h2 class="fw-bold mb-1">Dashboard Administrator</h2>
<p class="text-muted mb-4">Ringkasan data akademik aktif SIAKAD</p>

<div class="row g-3 mb-4">
    <div class="col-md-4 col-xl">
        <div class="card border-0 shadow-sm bg-primary text-white h-100">
            <div class="card-body">
                <div class="small text-white-50">Program Studi</div>
                <div class="fs-2 fw-bold"><?= $totalProdi ?></div>
                <a href="<?= base_url('/admin/prodi') ?>" class="text-white small text-decoration-none">Kelola &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xl">
        <div class="card border-0 shadow-sm bg-success text-white h-100">
            <div class="card-body">
                <div class="small text-white-50">Total Dosen</div>
                <div class="fs-2 fw-bold"><?= $totalDosen ?></div>
                <a href="<?= base_url('/admin/dosen') ?>" class="text-white small text-decoration-none">Kelola &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xl">
        <div class="card border-0 shadow-sm bg-info text-white h-100">
            <div class="card-body">
                <div class="small text-white-50">Total Mahasiswa</div>
                <div class="fs-2 fw-bold"><?= $totalMahasiswa ?></div>
                <a href="<?= base_url('/admin/mahasiswa') ?>" class="text-white small text-decoration-none">Kelola &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl">
        <div class="card border-0 shadow-sm bg-warning text-dark h-100">
            <div class="card-body">
                <div class="small">Mata Kuliah</div>
                <div class="fs-2 fw-bold"><?= $totalMatkul ?></div>
                <a href="<?= base_url('/admin/matakuliah') ?>" class="text-dark small text-decoration-none">Kelola &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl">
        <div class="card border-0 shadow-sm bg-dark text-white h-100">
            <div class="card-body">
                <div class="small text-white-50">Kelas Dibuka</div>
                <div class="fs-2 fw-bold"><?= $totalKelas ?></div>
                <a href="<?= base_url('/admin/kelas') ?>" class="text-white small text-decoration-none">Kelola &rarr;</a>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
        <span>Daftar Kelas Perkuliahan Aktif</span>
        <a href="<?= base_url('/admin/kelas') ?>" class="btn btn-sm btn-outline-primary">Kelola Kelas</a>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Mata Kuliah</th>
                    <th>Kelas</th>
                    <th>Dosen Pengampu</th>
                    <th>Jadwal &amp; Ruang</th>
                    <th>Kuota</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kelasList as $k) : ?>
                    <tr>
                        <td>
                            <div class="fw-semibold"><?= esc($k['kode_mk']) ?> — <?= esc($k['nama_mk']) ?></div>
                            <small class="text-muted"><?= esc($k['nama_prodi']) ?> &middot; <?= $k['sks'] ?> SKS</small>
                        </td>
                        <td><span class="badge bg-primary"><?= esc($k['nama_kelas']) ?></span></td>
                        <td><?= esc($k['nama_dosen']) ?></td>
                        <td>
                            <div><?= esc($k['jadwal']) ?></div>
                            <small class="text-muted"><?= esc($k['ruangan']) ?> (<?= esc($k['tahun_ajaran']) ?>)</small>
                        </td>
                        <td><span class="badge bg-secondary"><?= $k['terisi'] ?> / <?= $k['kuota'] ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>