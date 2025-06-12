
<?php $__env->startSection('title', 'Laporan Produk'); ?>
<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-0">Laporan Produk</h1>
        <p class="text-muted">Ringkasan dan daftar lengkap produk.</p>
    </div>
    <div>
        <a href="<?php echo e(route('produk.laporan.csv')); ?>" class="btn btn-success me-2">
            <i class="fas fa-file-csv"></i> Download CSV
        </a>
        <a href="<?php echo e(route('produk.laporan.pdf', request()->query())); ?>" class="btn btn-danger me-2">
            <i class="fas fa-file-pdf"></i> Download PDF
        </a>
        <a href="<?php echo e(route('produk.index')); ?>" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>

<!-- Kartu Statistik -->
<div class="row mb-4">
    <div class="col-md-3">
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
    <div class="col-md-3">
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
    <div class="col-md-3">
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
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="icon" style="background-color: #EF4444;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <h5 class="card-title fw-bold mb-0"><?php echo e($stokRendah ?? 0); ?></h5>
                    <p class="card-text text-muted">Stok Rendah</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter dan Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('produk.laporan')); ?>" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    <?php $__currentLoopData = $kategoris ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($kategori); ?>" <?php echo e(request('kategori') == $kategori ? 'selected' : ''); ?>>
                            <?php echo e($kategori); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Supplier</label>
                <select name="supplier" class="form-select">
                    <option value="">Semua Supplier</option>
                    <?php $__currentLoopData = $suppliers ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($supplier); ?>" <?php echo e(request('supplier') == $supplier ? 'selected' : ''); ?>>
                            <?php echo e($supplier); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Cari Produk</label>
                <input type="text" name="search" class="form-control" 
                       placeholder="Nama produk atau SKU..." 
                       value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Produk -->
<div class="card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 fw-bold">Daftar Produk Lengkap</h5>
        <div class="d-flex align-items-center">
            <small class="text-muted me-3">
                Menampilkan <?php echo e($produks->count()); ?> dari <?php echo e($produks->total()); ?> produk
            </small>
            <select class="form-select form-select-sm" style="width: auto;" onchange="changePerPage(this.value)">
                <option value="10" <?php echo e(request('per_page') == 10 ? 'selected' : ''); ?>>10 per halaman</option>
                <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25 per halaman</option>
                <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50 per halaman</option>
                <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>100 per halaman</option>
            </select>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>
                            <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'nama_produk', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])); ?>" 
                               class="text-decoration-none text-dark">
                                Nama Produk
                                <?php if(request('sort') == 'nama_produk'): ?>
                                    <i class="fas fa-sort-<?php echo e(request('direction') == 'asc' ? 'up' : 'down'); ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>SKU</th>
                        <th>
                            <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'kategori', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])); ?>" 
                               class="text-decoration-none text-dark">
                                Kategori
                                <?php if(request('sort') == 'kategori'): ?>
                                    <i class="fas fa-sort-<?php echo e(request('direction') == 'asc' ? 'up' : 'down'); ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'jumlah', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])); ?>" 
                               class="text-decoration-none text-dark">
                                Stok
                                <?php if(request('sort') == 'jumlah'): ?>
                                    <i class="fas fa-sort-<?php echo e(request('direction') == 'asc' ? 'up' : 'down'); ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'harga_beli', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])); ?>" 
                               class="text-decoration-none text-dark">
                                Harga Beli
                                <?php if(request('sort') == 'harga_beli'): ?>
                                    <i class="fas fa-sort-<?php echo e(request('direction') == 'asc' ? 'up' : 'down'); ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>Supplier</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $produks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $produk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e(($produks->currentPage() - 1) * $produks->perPage() + $index + 1); ?></td>
                        <td>
                            <div class="fw-semibold"><?php echo e($produk->nama_produk); ?></div>
                            <?php if($produk->deskripsi): ?>
                                <small class="text-muted"><?php echo e(Str::limit($produk->deskripsi, 50)); ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <code class="bg-light px-2 py-1 rounded"><?php echo e($produk->sku); ?></code>
                        </td>
                        <td>
                            <span class="badge bg-secondary"><?php echo e($produk->kategori); ?></span>
                        </td>
                        <td>
                            <span class="badge <?php echo e($produk->jumlah <= 10 ? 'bg-danger' : ($produk->jumlah <= 50 ? 'bg-warning' : 'bg-success')); ?>">
                                <?php echo e($produk->jumlah); ?>

                            </span>
                        </td>
                        <td>Rp <?php echo e(number_format($produk->harga_beli, 0, ',', '.')); ?></td>
                        <td><?php echo e($produk->supplier); ?></td>
                        <td>
                            <?php if($produk->jumlah <= 0): ?>
                                <span class="badge bg-danger">Habis</span>
                            <?php elseif($produk->jumlah <= 10): ?>
                                <span class="badge bg-warning">Stok Rendah</span>
                            <?php else: ?>
                                <span class="badge bg-success">Tersedia</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-box-open fa-3x mb-3"></i>
                            <p class="mb-0"><?php echo e(request()->hasAny(['search', 'kategori', 'supplier']) ? 'Tidak ada produk yang sesuai dengan filter.' : 'Data produk masih kosong.'); ?></p>
                            <?php if(request()->hasAny(['search', 'kategori', 'supplier'])): ?>
                                <a href="<?php echo e(route('produk.laporan')); ?>" class="btn btn-sm btn-outline-primary mt-2">
                                    <i class="fas fa-times"></i> Clear Filter
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if($produks->hasPages()): ?>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <small class="text-muted">
                        Menampilkan <?php echo e($produks->firstItem()); ?> sampai <?php echo e($produks->lastItem()); ?> 
                        dari <?php echo e($produks->total()); ?> hasil
                    </small>
                </div>
                <div>
                    <?php echo e($produks->appends(request()->query())->links()); ?>

                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function changePerPage(value) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', value);
    url.searchParams.delete('page'); // Reset to first page
    window.location.href = url.toString();
}
</script>

<!-- Pie Chart Kategori -->
<div class="row mb-4">
    <div class="col-lg-4">
        <div class="card">
             <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold">Stok per Kategori</h5>
            </div>
            <div class="card-body">
                <canvas id="categoryPieChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
             <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold">
                    <a href="<?php echo e(route('produk.laporan.pdf', request()->query())); ?>" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </h5>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Tubes Pergudangan\resources\views/produk/laporan.blade.php ENDPATH**/ ?>