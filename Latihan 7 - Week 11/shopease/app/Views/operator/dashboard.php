<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 mb-2">
                    ROLE: OPERATOR TOKO
                </span>
                <h1 class="fw-bold mb-1">Dashboard Operator ShopEase</h1>
                <p class="text-secondary mb-0">
                    Login sebagai <strong class="text-white"><?= esc(session()->get('name')) ?></strong> (<?= esc(session()->get('email')) ?>)
                </p>
            </div>
            <form action="<?= site_url('logout') ?>" method="POST">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-outline-danger btn-sm px-3">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </div>

        <div class="card-gaming p-4">
            <h5 class="fw-bold text-info mb-2"><i class="bi bi-box-seam me-2"></i>Area Operasional Pesanan</h5>
            <p class="text-secondary small mb-0">
                Halaman ini hanya dapat diakses oleh role <code>operator</code> melalui <code>AuthFilter (auth:operator)</code>. Modul pemrosesan pesanan dan input nomor resi akan aktif di Week 12.
            </p>
        </div>
    </div>
</section>
<?= $this->endSection() ?>