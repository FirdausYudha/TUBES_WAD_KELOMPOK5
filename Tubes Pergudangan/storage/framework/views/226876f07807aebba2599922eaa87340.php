
<?php $__env->startSection('title', 'Daftar Produk'); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="card shadow-sm rounded-3">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Daftar Produk</h3>
                <a href="<?php echo e(route('produk.create')); ?>" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Produk
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Harga Beli</th>
                            <th>Supplier</th>
                            <th>SKU</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $produks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $produk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($produks->firstItem() + $index); ?></td>
                            <td><?php echo e($produk->nama_produk); ?></td>
                            <td><span class="badge bg-secondary"><?php echo e($produk->kategori); ?></span></td>
                            <td><?php echo e($produk->jumlah); ?></td>
                            <td>Rp <?php echo e(number_format($produk->harga_beli, 0, ',', '.')); ?></td>
                            <td><?php echo e($produk->supplier); ?></td>
                            <td><?php echo e($produk->sku); ?></td>
                            <td class="text-center">
                                <form action="<?php echo e(route('produk.destroy', $produk->id)); ?>" method="POST" class="d-inline">
                                    <a href="<?php echo e(route('produk.edit', $produk->id)); ?>" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" title="Hapus">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                Belum ada data produk. Silakan tambah produk baru.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                <?php echo e($produks->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Tubes Pergudangan\resources\views/produk/index.blade.php ENDPATH**/ ?>