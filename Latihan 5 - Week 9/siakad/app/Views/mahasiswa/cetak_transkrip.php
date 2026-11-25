<?php
/**
 * @var array $mhs
 * @var array $semuaNilai
 * @var array $ipkData
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transkrip Nilai — <?= esc($mhs['nrp']) ?></title>
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
            <h4 class="fw-bold mb-0">TRANSKRIP NILAI AKADEMIK</h4>
            <div class="small text-muted">Sistem Informasi Akademik Terpadu (SIAKAD) &middot; <?= esc($mhs['fakultas']) ?></div>
        </div>

        <table class="table table-sm table-borderless mb-4">
            <tr>
                <th style="width: 18%;">NRP</th><td style="width: 32%;">: <?= esc($mhs['nrp']) ?></td>
                <th style="width: 18%;">Program Studi</th><td>: <?= esc($mhs['nama_prodi']) ?></td>
            </tr>
            <tr>
                <th>Nama</th><td>: <?= esc($mhs['nama']) ?></td>
                <th>Angkatan</th><td>: <?= esc($mhs['angkatan']) ?></td>
            </tr>
        </table>

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Smt</th>
                    <th>Kode</th>
                    <th>Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Nilai</th>
                    <th>Bobot</th>
                    <th>Mutu</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalMutu = 0; ?>
                <?php foreach ($semuaNilai as $i => $row) : ?>
                    <?php
                        $mutu = $row['bobot'] !== null ? ((int) $row['sks']) * ((float) $row['bobot']) : null;
                        if ($mutu !== null) {
                            $totalMutu += $mutu;
                        }
                    ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= $row['semester_ambil'] ?></td>
                        <td><?= esc($row['kode_mk']) ?></td>
                        <td><?= esc($row['nama_mk']) ?></td>
                        <td><?= $row['sks'] ?></td>
                        <td><?= esc($row['nilai_huruf'] ?? '-') ?></td>
                        <td><?= $row['bobot'] !== null ? number_format((float) $row['bobot'], 2) : '-' ?></td>
                        <td><?= $mutu !== null ? number_format($mutu, 2) : '-' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="fw-bold table-light">
                    <td colspan="4" class="text-end">Total SKS Lulus / Total Mutu</td>
                    <td><?= $ipkData['total_sks'] ?></td>
                    <td colspan="2" class="text-end">IPK: <?= number_format((float) $ipkData['ipk'], 2) ?></td>
                    <td><?= number_format($totalMutu, 2) ?></td>
                </tr>
            </tfoot>
        </table>

        <div class="text-end small mt-5">
            <div>Surabaya, <?= date('d M Y') ?></div>
            <div>Dosen Wali / Akademik</div>
            <div style="height: 60px;"></div>
            <div class="fw-bold text-decoration-underline"><?= esc($mhs['nama_dosen_wali'] ?? 'Bagian Akademik') ?></div>
        </div>
    </div>
</body>
</html>