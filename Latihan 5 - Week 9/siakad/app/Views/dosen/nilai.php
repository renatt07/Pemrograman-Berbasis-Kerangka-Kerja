<?php
/**
 * @var array $kelas
 * @var array $peserta
 */
?>
<?= $this->extend('layout/siakad') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="fw-bold mb-0"><?= esc($kelas['kode_mk']) ?> — <?= esc($kelas['nama_mk']) ?> (Kelas <?= esc($kelas['nama_kelas']) ?>)</h2>
        <small class="text-muted"><?= esc($kelas['jadwal']) ?> &middot; Ruang <?= esc($kelas['ruangan']) ?> &middot; <?= esc($kelas['tahun_ajaran']) ?></small>
    </div>
    <a href="<?= base_url('/dosen/kelas') ?>" class="btn btn-secondary btn-sm">&larr; Kembali</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold">Daftar Peserta &amp; Input Nilai (0–100)</span>
        <small class="text-muted">A(&ge;86), AB(&ge;76), B(&ge;66), BC(&ge;61), C(&ge;56), D(&ge;41), E(&lt;41)</small>
    </div>
    <div class="card-body">
        <?php if (empty($peserta)) : ?>
            <p class="text-center text-muted mb-0 py-3">Belum ada mahasiswa yang mengambil kelas ini.</p>
        <?php else : ?>
            <form action="<?= base_url('/dosen/kelas/' . $kelas['id'] . '/nilai') ?>" method="post">
                <?= csrf_field() ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>NRP</th>
                                <th>Nama Mahasiswa</th>
                                <th>Angkatan</th>
                                <th style="width: 150px;">Nilai Angka</th>
                                <th>Huruf</th>
                                <th>Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($peserta as $i => $p) : ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><code><?= esc($p['nrp']) ?></code></td>
                                    <td class="fw-semibold"><?= esc($p['nama_mahasiswa']) ?></td>
                                    <td><?= esc($p['angkatan']) ?></td>
                                    <td>
                                        <input type="number" step="0.01" min="0" max="100"
                                               name="nilai[<?= $p['id'] ?>]"
                                               class="form-control form-control-sm"
                                               value="<?= esc($p['nilai_angka'] ?? '') ?>"
                                               placeholder="0 - 100">
                                    </td>
                                    <td>
                                        <?php if ($p['nilai_huruf']) : ?>
                                            <span class="badge bg-primary"><?= esc($p['nilai_huruf']) ?></span>
                                        <?php else : ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $p['bobot'] !== null ? number_format((float) $p['bobot'], 2) : '-' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-primary fw-semibold">
                    <i class="bi bi-save me-1"></i>Simpan Semua Nilai
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>