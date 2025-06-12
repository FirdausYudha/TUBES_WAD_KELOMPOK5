
<?php $__env->startSection('title', 'Tambah Produk'); ?>
<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-0">Tambah Produk Baru</h1>
        <p class="text-muted">Isi formulir di bawah untuk menambahkan produk ke inventaris.</p>
    </div>
     <a href="<?php echo e(route('produk.index')); ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-body p-4">
        <form action="<?php echo e(route('produk.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row g-4">
                <div class="col-md-12">
                    <label for="nama_produk" class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="sku" class="form-label">SKU (Kode Unik Produk)</label>
                    <input type="text" name="sku" id="sku" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="kategori" class="form-label">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" required>
                </div>
                 <div class="col-md-6">
                    <label for="jumlah" class="form-label">Jumlah Stok Awal</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" required min="0">
                </div>
                <div class="col-md-6">
                    <label for="harga_beli" class="form-label">Harga Beli</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="harga_beli" id="harga_beli" class="form-control" required min="0">
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="supplier" class="form-label">Nama Supplier</label>
                    <input type="text" name="supplier" id="supplier" class="form-control" required>
                </div>
            </div>
            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-2"></i> Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\egiag\Downloads\Tubes Pergudangan\Tubes Pergudangan\resources\views/produk/create.blade.php ENDPATH**/ ?>