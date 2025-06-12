
<?php $__env->startSection('title', 'Edit Produk'); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="card shadow-sm rounded-3 mx-auto" style="max-width: 800px;">
        <div class="card-header">
            <h3 class="card-title mb-0">Edit Data Produk</h3>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('produk.update', $produk->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="<?php echo e($produk->nama_produk); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="sku" class="form-label">SKU (Kode Unik)</label>
                        <input type="text" name="sku" id="sku" class="form-control" value="<?php echo e($produk->sku); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="kategori" class="form-label">Kategori</label>
                        <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo e($produk->kategori); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="supplier" class="form-label">Supplier</label>
                        <input type="text" name="supplier" id="supplier" class="form-control" value="<?php echo e($produk->supplier); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" value="<?php echo e($produk->jumlah); ?>" required min="0">
                    </div>
                    <div class="col-md-6">
                        <label for="harga_beli" class="form-label">Harga Beli</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="harga_beli" id="harga_beli" class="form-control" value="<?php echo e($produk->harga_beli); ?>" required min="0">
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-end">
                    <a href="<?php echo e(route('produk.index')); ?>" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-1"></i> Update Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Tubes Pergudangan\resources\views/produk/edit.blade.php ENDPATH**/ ?>