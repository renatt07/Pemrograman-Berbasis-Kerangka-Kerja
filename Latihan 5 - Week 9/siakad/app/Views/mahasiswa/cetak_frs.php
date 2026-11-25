<?php
/**
 * @var array $mhs
 * @var array $frsAktif
 * @var int   $sksAktif
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak FRS — <?= esc($mhs['nrp']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body class="bg-white py-4">
    <div class="container" style="max-width: 820px;">
        <div class="d-flex justify-content-end mb-3 no-print">
            <button onclick="window.print()" class="btn btn-primary btn-sm">Cetak / Simpan PDF</button>
        </div>

        <div class="text-center border-bottom border-2 border-dark pb-3 mb-4">
            <h4 class="fw-bold mb-0">FORMULIR RENCANA STUDI (FRS)</h4>
            <div class="small text-muted">Sistem Informasi Akademik Terpadu (SIAKAD) &middot; <?= esc($mhs['fakultas']) ?></div>
        </div>

        <table class="table table-sm table-borderless mb-4">
            <tr>
                <th style="width: 18%;">NRP</th><td style="width: 32%;">: <?= esc($mhs['nrp']) ?></td>
                <th style="width: 18%;">Program Studi</th><td>: <?= esc($mhs['nama_prodi']) ?></td>
            </tr>
            <tr>
                <th>Nama</th><td>: <?= esc($mhs['nama']) ?></td>
                <th>Semester Aktif</th><td>: Semester <?= esc($mhs['semester_aktif']) ?></td>
            </tr>
            <tr>
                <th>Dosen Wali</th><td>: <?= esc($mhs['nama_dosen_wali'] ?? '-') ?></td>
                <th>Total SKS</th><td>: <?= $sksAktif ?> / <?= $mhs['batas_sks'] ?> SKS</td>
            </tr>
        </table>

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Mata Kuliah</th>
                    <th>Kelas</th>
                    <th>SKS</th>
                    <th>Jadwal &amp; Ruang</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($frsAktif)) : ?>
                    <tr><td colspan="6" class="text-center py-3">Belum ada mata kuliah diambil.</td></tr>
                <?php else : ?>
                    <?php foreach ($frsAktif as $i => $f) : ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($f['kode_mk']) ?></td>
                            <td><?= esc($f['nama_mk']) ?></td>
                            <td><?= esc($f['nama_kelas']) ?></td>
                            <td><?= $f['sks'] ?></td>
                            <td><?= esc($f['jadwal']) ?> (<?= esc($f['ruangan']) ?>)</td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr class="fw-bold">
                    <td colspan="4" class="text-end">Total SKS Diambil</td>
                    <td colspan="2"><?= $sksAktif ?> SKS</td>
                </tr>
            </tfoot>
        </table>

        <div class="row mt-5 pt-3 text-center small">
            <div class="col-6">
                <div>Menyetujui, Dosen Wali</div>
                <div style="height: 65px;"></div>
                <div class="fw-bold text-decoration-underline"><?= esc($mhs['nama_dosen_wali'] ?? '................................') ?></div>
                <div>NIP. <?= esc($mhs['nip_dosen_wali'] ?? '-') ?></div>
            </div>
            <div class="col-6">
                <div>Surabaya, <?= date('d M Y') ?></div>
                <div>Mahasiswa</div>
                <div style="height: 45px;"></div>
                <div class="fw-bold text-decoration-underline"><?= esc($mhs['nama']) ?></div>
                <div>NRP. <?= esc($mhs['nrp']) ?></div>
            </div>
        </div>
    </div>
</body>
</html>