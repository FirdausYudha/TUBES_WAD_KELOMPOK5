<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Produk PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 0;
        }
        p {
            text-align: center;
            margin-top: 0;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <h1>Laporan Produk</h1>
    <p>Ringkasan dan daftar lengkap produk.</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>SKU</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Harga Beli</th>
                <th>Supplier</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $produks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $produk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td><?php echo e($produk->nama_produk); ?></td>
                <td><?php echo e($produk->sku); ?></td>
                <td><?php echo e($produk->kategori); ?></td>
                <td><?php echo e($produk->jumlah); ?></td>
                <td>Rp <?php echo e(number_format($produk->harga_beli, 0, ',', '.')); ?></td>
                <td><?php echo e($produk->supplier); ?></td>
                <td>
                    <?php if($produk->jumlah <= 0): ?>
                        Habis
                    <?php elseif($produk->jumlah <= 10): ?>
                        Stok Rendah
                    <?php else: ?>
                        Tersedia
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\Users\egiag\Downloads\Tubes Pergudangan\Tubes Pergudangan\resources\views/produk/laporan_pdf.blade.php ENDPATH**/ ?>