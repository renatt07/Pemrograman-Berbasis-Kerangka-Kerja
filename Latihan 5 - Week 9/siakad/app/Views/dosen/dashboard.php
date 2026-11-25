<?php
/**
 * @var array $dosen
 * @var array $kelasList
 * @var int   $totalKelas
 * @var int   $totalPerwalian
 */
?>
<?= $this->extend('layout/siakad') ?>

<?= $this->section('content') ?>
<h2 class="fw-bold mb-1">Dashboard Dosen</h2>
<p class="text-muted mb-4"><?= esc($dosen['nama']) ?> &middot; NIP: <?= esc($dosen['nip']) ?> &middot; <?= esc($dosen['nama_prodi']) ?></p>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="small text-white-50">Kelas yang Diampu</div>
                    <div class="fs-2 fw-bold"><?= $totalKelas ?></div>
                </div>
                <a href="<?= base_url('/dosen/kelas') ?>" class="btn btn-light btn-sm fw-semibold">Lihat Kelas &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="small text-white-50">Mahasiswa Perwalian</div>
                    <div class="fs-2 fw-bold"><?= $totalPerwalian ?></div>
                </div>
                <a href="<?= base_url('/dosen/perwalian') ?>" class="btn btn-light btn-sm fw-semibold">Lihat Perwalian &rarr;</a>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold">Daftar Kelas Ampu</div>
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Mata Kuliah</th>
                    <th>Kelas</th>
                    <th>Jadwal &amp; Ruang</th>
                    <th>Peserta</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($kelasList)) : ?>
                    <tr><td colspan="5" class="text-center text-muted py-3">Belum ada kelas yang diampu.</td></tr>
                <?php else : ?>
                    <?php foreach ($kelasList as $k) : ?>
                        <tr>
                            <td>
                                <div class="fw-semibold"><?= esc($k['kode_mk']) ?> — <?= esc($k['nama_mk']) ?></div>
                                <small class="text-muted"><?= $k['sks'] ?> SKS &middot; <?= esc($k['tahun_ajaran']) ?></small>
                            </td>
                            <td><span class="badge bg-primary"><?= esc($k['nama_kelas']) ?></span></td>
                            <td>
                                <div><?= esc($k['jadwal']) ?></div>
                                <small class="text-muted"><?= esc($k['ruangan']) ?></small>
                            </td>
                            <td><span class="badge bg-secondary"><?= $k['terisi'] ?> / <?= $k['kuota'] ?></span></td>
                            <td>
                                <a href="<?= base_url('/dosen/kelas/' . $k['id']) ?>" class="btn btn-sm btn-primary">Kelola Nilai</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>