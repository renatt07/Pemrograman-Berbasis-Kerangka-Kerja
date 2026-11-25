<?php
/** @var string $title */
?>
<?= $this->extend('layout/siakad') ?>
<?= $this->section('content') ?>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="fw-bold"><?= esc($title) ?></h4>
        <p class="mb-0 text-muted">Login dan RoleFilter untuk role <strong><?= esc(session()->get('role')) ?></strong> berhasil berjalan.</p>
    </div>
</div>
<?= $this->endSection() ?>