<?php
/**
 * @var array $dosen
 * @var array $mahasiswaList
 */
?>
<?= $this->extend('layout/siakad') ?>

<?= $this->section('content') ?>
<h2 class="fw-bold mb-1">Mahasiswa Perwalian</h2>
<p class="text-muted mb-4">Daftar mahasiswa bimbingan akademik <?= esc($dosen['nama']) ?></p>

<div class="card border-0 shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>NRP</th>
                    <th>Nama Mahasiswa</th>
                    <th>Prodi &amp; Angkatan</th>
                    <th>Semester Aktif</th>
                    <th>SKS Diambil (Aktif)</th>
                    <th>Total SKS Lulus</th>
                    <th>IPK</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($mahasiswaList)) : ?>
                    <tr><td colspan="7" class="text-center text-muted py-3">Belum ada mahasiswa perwalian.</td></tr>
                <?php else : ?>
                    <?php foreach ($mahasiswaList as $m) : ?>
                        <tr>
                            <td><code><?= esc($m['nrp']) ?></code></td>
                            <td>
                                <div class="fw-semibold"><?= esc($m['nama']) ?></div>
                                <small class="text-muted"><?= esc($m['email']) ?></small>
                            </td>
                            <td><?= esc($m['nama_prodi']) ?> (<?= esc($m['angkatan']) ?>)</td>
                            <td>Semester <?= $m['semester_aktif'] ?></td>
                            <td><?= $m['sks_aktif'] ?> / <?= $m['batas_sks'] ?> SKS</td>
                            <td><?= $m['total_sks'] ?> SKS</td>
                            <td><span class="badge bg-success fs-6"><?= number_format((float) $m['ipk'], 2) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>