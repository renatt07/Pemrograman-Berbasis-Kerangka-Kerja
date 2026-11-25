<?php
/**
 * @var array $mhs
 * @var array $frsAktif
 * @var int   $sksAktif
 * @var array $kelasList
 * @var array $takenKelas
 */
?>
<?= $this->extend('layout/siakad') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-0">Pengisian FRS — Semester <?= $mhs['semester_aktif'] ?></h2>
        <small class="text-muted">Beban SKS Terambil: <strong><?= $sksAktif ?> / <?= $mhs['batas_sks'] ?> SKS</strong></small>
    </div>
    <a href="<?= base_url('/mahasiswa/cetak/frs') ?>" target="_blank" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-printer me-1"></i>Cetak FRS
    </a>
</div>

<!-- Daftar Kelas yang Sudah Diambil -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-semibold">Mata Kuliah di FRS Semester <?= $mhs['semester_aktif'] ?></div>
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Mata Kuliah</th>
                    <th>Kelas</th>
                    <th>Dosen Pengampu</th>
                    <th>Jadwal &amp; Ruang</th>
                    <th>SKS</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($frsAktif)) : ?>
                    <tr><td colspan="7" class="text-center text-muted py-3">Belum ada mata kuliah diambil. Silakan pilih dari tabel kelas di bawah.</td></tr>
                <?php else : ?>
                    <?php foreach ($frsAktif as $f) : ?>
                        <tr>
                            <td><span class="badge bg-dark"><?= esc($f['kode_mk']) ?></span></td>
                            <td class="fw-semibold"><?= esc($f['nama_mk']) ?></td>
                            <td><span class="badge bg-primary"><?= esc($f['nama_kelas']) ?></span></td>
                            <td><?= esc($f['nama_dosen']) ?></td>
                            <td><?= esc($f['jadwal']) ?> <small class="text-muted">(<?= esc($f['ruangan']) ?>)</small></td>
                            <td><?= $f['sks'] ?></td>
                            <td>
                                <?php if ($f['nilai_angka'] === null) : ?>
                                    <form action="<?= base_url('/mahasiswa/frs/hapus/' . $f['id']) ?>" method="post" onsubmit="return confirm('Batalkan kelas ini dari FRS?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Drop</button>
                                    </form>
                                <?php else : ?>
                                    <span class="badge bg-success">Sudah Dinilai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Daftar Semua Kelas Tersedia -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold">Daftar Kelas yang Dibuka</div>
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Mata Kuliah</th>
                    <th>Kelas</th>
                    <th>Dosen</th>
                    <th>Jadwal</th>
                    <th>SKS</th>
                    <th>Kuota</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kelasList as $k) : ?>
                    <?php
                        $sudahDiambil = in_array($k['id'], $takenKelas, false);
                        $penuh        = (int) $k['terisi'] >= (int) $k['kuota'];
                    ?>
                    <tr>
                        <td>
                            <div class="fw-semibold"><?= esc($k['kode_mk']) ?> — <?= esc($k['nama_mk']) ?></div>
                            <small class="text-muted">Smt <?= $k['semester'] ?> &middot; <?= esc($k['tahun_ajaran']) ?></small>
                        </td>
                        <td><span class="badge bg-primary"><?= esc($k['nama_kelas']) ?></span></td>
                        <td><?= esc($k['nama_dosen']) ?></td>
                        <td>
                            <div><?= esc($k['jadwal']) ?></div>
                            <small class="text-muted"><?= esc($k['ruangan']) ?></small>
                        </td>
                        <td><?= $k['sks'] ?></td>
                        <td><span class="badge <?= $penuh ? 'bg-danger' : 'bg-secondary' ?>"><?= $k['terisi'] ?> / <?= $k['kuota'] ?></span></td>
                        <td>
                            <?php if ($sudahDiambil) : ?>
                                <button class="btn btn-sm btn-success" disabled>Diambil</button>
                            <?php elseif ($penuh) : ?>
                                <button class="btn btn-sm btn-secondary" disabled>Penuh</button>
                            <?php else : ?>
                                <form action="<?= base_url('/mahasiswa/frs/ambil') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="kelas_id" value="<?= $k['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-primary">Ambil</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>