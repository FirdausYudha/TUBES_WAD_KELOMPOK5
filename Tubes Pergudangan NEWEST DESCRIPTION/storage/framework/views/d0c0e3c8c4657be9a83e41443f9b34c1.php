
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>

<!-- Header Halaman -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-0">Dashboard</h1>
        <p class="text-muted">Ringkasan inventaris Anda saat ini.</p>
    </div>
    <div>
        <a href="<?php echo e(route('produk.laporan')); ?>" class="btn btn-primary">Lihat Laporan</a>
    </div>
</div>

<!-- Kartu Statistik -->
<div class="row">
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="icon bg-primary">
                    <i class="fas fa-box-open"></i>
                </div>
                <div>
                    <h5 class="card-title fw-bold mb-0"><?php echo e($totalProduk); ?></h5>
                    <p class="card-text text-muted">Total Jenis Produk</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="icon" style="background-color: #10B981;">
                    <i class="fas fa-boxes-stacked"></i>
                </div>
                <div>
                    <h5 class="card-title fw-bold mb-0"><?php echo e($totalStok); ?></h5>
                    <p class="card-text text-muted">Total Stok Keseluruhan</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="icon" style="background-color: #F59E0B;">
                    <i class="fas fa-tags"></i>
                </div>
                <div>
                    <h5 class="card-title fw-bold mb-0"><?php echo e($totalKategori); ?></h5>
                    <p class="card-text text-muted">Jumlah Kategori</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Tabel Produk -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold">Daftar Produk Terbaru</h5>
            </div>
            <div class="card-body">
                <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $produks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $produk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($produks->firstItem() + $index); ?></td>
                                <td><strong class="text-dark"><?php echo e($produk->nama_produk); ?></strong><br><small class="text-muted">SKU: <?php echo e($produk->sku); ?></small></td>
                                <td><span class="badge" style="background-color: #E2E8F0; color: #475569;"><?php echo e($produk->kategori); ?></span></td>
                                <td><?php echo e($produk->jumlah); ?></td>
                                <td>Rp <?php echo e(number_format($produk->harga_beli, 0, ',', '.')); ?></td>
                                <td class="text-center">
                                     <a href="<?php echo e(route('produk.edit', $produk->id)); ?>" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                    <form action="<?php echo e(route('produk.destroy', $produk->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-box-open fa-3x mb-3"></i>
                                    <p>Data produk masih kosong.</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if($produks->hasPages()): ?>
                <div class="d-flex justify-content-end mt-3">
                    <?php echo e($produks->links('pagination::bootstrap-5')); ?>

                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const categoryData = <?php echo json_encode($chartData, 15, 512) ?>;

    const ctx = document.getElementById('categoryPieChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: Object.keys(categoryData),
            datasets: [{
                label: 'Jumlah Stok',
                data: Object.values(categoryData),
                backgroundColor: [
                    '#4A69E2',
                    '#10B981',
                    '#F59E0B',
                    '#6366F1',
                    '#EF4444',
                    '#8B5CF6',
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\egiag\Downloads\Tubes Pergudangan\Tubes Pergudangan\resources\views/produk/index.blade.php ENDPATH**/ ?>