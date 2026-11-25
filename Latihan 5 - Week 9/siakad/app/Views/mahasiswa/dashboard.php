<?php
/**
 * @var array $mhs
 * @var array $ipkData
 * @var array $frsAktif
 * @var int   $sksAktif
 */
?>
<?= $this->extend('layout/siakad') ?>

<?= $this->section('content') ?>
<h2 class="fw-bold mb-1">Dashboard Mahasiswa</h2>
<p class="text-muted mb-4">Selamat datang, <?= esc($mhs['nama']) ?></p>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white h-100">
            <div class="card-body">
                <div class="small text-white-50">Indeks Prestasi Kumulatif (IPK)</div>
                <div class="fs-2 fw-bold"><?= number_format((float) $ipkData['ipk'], 2) ?></div>
                <div class="small text-white-50">Total SKS Lulus: <?= $ipkData['total_sks'] ?> SKS</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-success text-white h-100">
            <div class="card-body">
                <div class="small text-white-50">FRS Semester <?= $mhs['semester_aktif'] ?></div>
                <div class="fs-2 fw-bold"><?= $sksAktif ?> / <?= $mhs['batas_sks'] ?> SKS</div>
                <a href="<?= base_url('/mahasiswa/frs') ?>" class="text-white small text-decoration-none">Isi / Ubah FRS &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-dark text-white h-100">
            <div class="card-body">
                <div class="small text-white-50">Cetak Dokumen Akademik</div>
                <div class="d-flex gap-2 mt-3">
                    <a href="<?= base_url('/mahasiswa/cetak/frs') ?>" target="_blank" class="btn btn-warning btn-sm fw-semibold">
                        <i class="bi bi-printer me-1"></i>Cetak FRS
                    </a>
                    <a href="<?= base_url('/mahasiswa/cetak/transkrip') ?>" target="_blank" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-file-earmark-text me-1"></i>Transkrip
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold">Profil Mahasiswa</div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr><th class="text-muted" style="width: 40%;">NRP</th><td class="fw-semibold"><?= esc($mhs['nrp']) ?></td></tr>
                    <tr><th class="text-muted">Nama Lengkap</th><td><?= esc($mhs['nama']) ?></td></tr>
                    <tr><th class="text-muted">Email</th><td><?= esc($mhs['email']) ?></td></tr>
                    <tr><th class="text-muted">Program Studi</th><td><?= esc($mhs['nama_prodi']) ?> (<?= esc($mhs['fakultas']) ?>)</td></tr>
                    <tr><th class="text-muted">Angkatan</th><td><?= esc($mhs['angkatan']) ?></td></tr>
                    <tr><th class="text-muted">Semester Aktif</th><td>Semester <?= esc($mhs['semester_aktif']) ?></td></tr>
                    <tr><th class="text-muted">Dosen Wali</th><td><?= esc($mhs['nama_dosen_wali'] ?? 'Belum ditentukan') ?></td></tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
                <span>Jadwal FRS Semester <?= $mhs['semester_aktif'] ?></span>
                <a href="<?= base_url('/mahasiswa/frs') ?>" class="btn btn-sm btn-outline-primary">Kelola FRS</a>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Mata Kuliah</th>
                            <th>Kelas</th>
                            <th>Jadwal</th>
                            <th>SKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($frsAktif)) : ?>
                            <tr><td colspan="4" class="text-center text-muted py-3">Belum ada kelas diambil pada semester ini.</td></tr>
                        <?php else : ?>
                            <?php foreach ($frsAktif as $f) : ?>
                                <tr>
                                    <td>
                                        <div class="fw-semibold"><?= esc($f['kode_mk']) ?> — <?= esc($f['nama_mk']) ?></div>
                                        <small class="text-muted"><?= esc($f['nama_dosen']) ?></small>
                                    </td>
                                    <td><span class="badge bg-primary"><?= esc($f['nama_kelas']) ?></span></td>
                                    <td>
                                        <div><?= esc($f['jadwal']) ?></div>
                                        <small class="text-muted"><?= esc($f['ruangan']) ?></small>
                                    </td>
                                    <td><?= $f['sks'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>