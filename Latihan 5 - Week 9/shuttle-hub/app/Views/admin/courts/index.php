<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mt-2 mb-4">
    <div>
        <h1 class="mb-0">Kelola Lapangan</h1>
        <small class="text-muted">Tambah, ubah, unggah foto, atau hapus data lapangan badminton</small>
    </div>
    <a href="<?= base_url('/admin/courts/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Tambah Lapangan
    </a>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i> Daftar Lapangan ShuttleHub
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 110px;">Foto</th>
                    <th>Nama Lapangan</th>
                    <th>Tipe Lantai</th>
                    <th>Harga / Jam</th>
                    <th>Status</th>
                    <th style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($courts)) : ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada data lapangan.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($courts as $court) : ?>
                        <tr>
                            <td>
                                <?php if (! empty($court['image'])) : ?>
                                    <img src="<?= base_url('uploads/courts/' . $court['image']) ?>" alt="<?= esc($court['name']) ?>" class="img-thumbnail" style="width: 90px; height: 60px; object-fit: cover;">
                                <?php else : ?>
                                    <div class="bg-light border rounded text-center text-muted small py-3">No Foto</div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-semibold"><?= esc($court['name']) ?></div>
                                <small class="text-muted"><?= esc(mb_strimwidth($court['description'] ?? '-', 0, 70, '...')) ?></small>
                            </td>
                            <td><?= esc($court['floor_type']) ?></td>
                            <td>Rp <?= number_format($court['price_per_hour'], 0, ',', '.') ?></td>
                            <td>
                                <?php if ($court['status'] === 'available') : ?>
                                    <span class="badge bg-success">Tersedia</span>
                                <?php else : ?>
                                    <span class="badge bg-secondary">Maintenance</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('/admin/courts/edit/' . $court['id']) ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="<?= base_url('/admin/courts/delete/' . $court['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus lapangan ini?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>