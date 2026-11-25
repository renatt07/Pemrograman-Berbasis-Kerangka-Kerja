<?php
/**
 * @var array $mhs
 * @var array $perSemester
 * @var array $ipkData
 */
?>
<?= $this->extend('layout/siakad') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h2 class="fw-bold mb-0">Hasil Studi &amp; IPK</h2>
        <small class="text-muted"><?= esc($mhs['nrp']) ?> — <?= esc($mhs['nama']) ?></small>
    </div>
    <a href="<?= base_url('/mahasiswa/cetak/transkrip') ?>" target="_blank" class="btn btn-primary btn-sm">
        <i class="bi bi-printer me-1"></i>Cetak Transkrip Nilai
    </a>
</div>

<div class="alert alert-primary d-flex justify-content-between align-items-center mb-4">
    <div>
        <strong>Indeks Prestasi Kumulatif (IPK):</strong>
        <span class="fs-5 fw-bold ms-2"><?= number_format((float) $ipkData['ipk'], 2) ?></span>
    </div>
    <div><strong>Total SKS Dinilai:</strong> <?= $ipkData['total_sks'] ?> SKS</div>
</div>

<?php if (empty($perSemester)) : ?>
    <div class="alert alert-info">Belum ada riwayat pengambilan mata kuliah.</div>
<?php else : ?>
    <?php foreach ($perSemester as $smt => $group) : ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-bold">Semester <?= $smt ?></span>
                <span class="badge bg-success">IPS: <?= number_format((float) $group['ips'], 2) ?> (<?= $group['sks'] ?> SKS)</span>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Mata Kuliah</th>
                            <th>Kelas</th>
                            <th>SKS</th>
                            <th>Nilai Angka</th>
                            <th>Huruf</th>
                            <th>Bobot</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($group['items'] as $row) : ?>
                            <tr>
                                <td><code><?= esc($row['kode_mk']) ?></code></td>
                                <td class="fw-semibold"><?= esc($row['nama_mk']) ?></td>
                                <td><?= esc($row['nama_kelas']) ?></td>
                                <td><?= $row['sks'] ?></td>
                                <td><?= $row['nilai_angka'] !== null ? number_format((float) $row['nilai_angka'], 2) : '<span class="text-muted">Belum dinilai</span>' ?></td>
                                <td>
                                    <?php if ($row['nilai_huruf']) : ?>
                                        <span class="badge bg-primary"><?= esc($row['nilai_huruf']) ?></span>
                                    <?php else : ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?= $row['bobot'] !== null ? number_format((float) $row['bobot'], 2) : '-' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<?= $this->endSection() ?>