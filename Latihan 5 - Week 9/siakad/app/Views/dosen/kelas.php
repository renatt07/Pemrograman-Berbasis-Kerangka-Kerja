<?php
/** @var array $kelasList */
?>
<?= $this->extend('layout/siakad') ?>

<?= $this->section('content') ?>
<h2 class="fw-bold mb-1">Kelas Diampu</h2>
<p class="text-muted mb-4">Pilih kelas untuk melihat peserta dan menginput nilai mahasiswa</p>

<div class="row g-3">
    <?php if (empty($kelasList)) : ?>
        <div class="col-12"><div class="alert alert-info">Anda belum mengampu kelas apa pun.</div></div>
    <?php else : ?>
        <?php foreach ($kelasList as $k) : ?>
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-dark"><?= esc($k['kode_mk']) ?></span>
                            <span class="badge bg-primary">Kelas <?= esc($k['nama_kelas']) ?></span>
                        </div>
                        <h5 class="fw-bold mb-1"><?= esc($k['nama_mk']) ?></h5>
                        <p class="text-muted small mb-3"><?= esc($k['tahun_ajaran']) ?> &middot; <?= $k['sks'] ?> SKS</p>
                        <div class="small text-muted mb-3">
                            <div><i class="bi bi-clock me-1"></i><?= esc($k['jadwal']) ?></div>
                            <div><i class="bi bi-geo-alt me-1"></i>Ruang <?= esc($k['ruangan']) ?></div>
                            <div><i class="bi bi-people me-1"></i>Peserta: <strong><?= $k['terisi'] ?> / <?= $k['kuota'] ?></strong></div>
                        </div>
                        <a href="<?= base_url('/dosen/kelas/' . $k['id']) ?>" class="btn btn-primary btn-sm mt-auto">
                            <i class="bi bi-pencil-square me-1"></i>Input / Kelola Nilai
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>