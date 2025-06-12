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
            @foreach($produks as $index => $produk)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $produk->nama_produk }}</td>
                <td>{{ $produk->sku }}</td>
                <td>{{ $produk->kategori }}</td>
                <td>{{ $produk->jumlah }}</td>
                <td>Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</td>
                <td>{{ $produk->supplier }}</td>
                <td>
                    @if($produk->jumlah <= 0)
                        Habis
                    @elseif($produk->jumlah <= 10)
                        Stok Rendah
                    @else
                        Tersedia
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
