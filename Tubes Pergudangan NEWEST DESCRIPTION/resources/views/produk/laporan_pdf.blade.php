<!-- {{--
File ini adalah template Blade untuk menghasilkan laporan produk dalam format PDF.
Berikut penjelasan lengkap per bagian:

1. Struktur HTML Dasar:
- <!DOCTYPE html> dan elemen <html> dengan atribut lang="id" untuk bahasa Indonesia.
- <head> berisi meta charset UTF-8, judul halaman, dan style CSS untuk tampilan PDF.

2. Style CSS:
- Mengatur font keluarga Arial, ukuran font 12px.
- Tabel menggunakan lebar 100%, border-collapse untuk menggabungkan border.
- Sel tabel (th, td) memiliki border 1px solid, padding 6px, dan teks rata kiri.
- Header tabel (th) diberi background abu-abu muda.
- Judul (h1) dan paragraf (p) diatur rata tengah dengan margin yang sesuai.

3. Body Dokumen:
- Judul utama "Laporan Produk" di tengah halaman.
- Paragraf deskriptif "Ringkasan dan daftar lengkap produk."
- Tabel yang menampilkan data produk.

4. Tabel Produk:
- Header tabel dengan kolom: No, Nama Produk, SKU, Kategori, Jumlah, Harga Beli, Supplier, Status.
- Baris data diisi dengan perulangan @foreach pada variabel $produks.
- Menampilkan nomor urut, nama produk, SKU, kategori, jumlah stok, harga beli (format Rupiah), dan supplier.
- Kolom status menampilkan:
  * "Habis" jika jumlah <= 0
  * "Stok Rendah" jika jumlah <= 10
  * "Tersedia" jika jumlah > 10

Fungsi utama file ini adalah menyediakan tampilan laporan produk yang rapi dan terstruktur dalam format PDF untuk keperluan cetak atau arsip.

--}} -->

<!DOCTYPE html>
<html lang="id">
<head>
    {{-- Mendefinisikan tipe dokumen HTML dan bahasa halaman --}}
    <meta charset="UTF-8"> {{-- Mengatur encoding karakter ke UTF-8 --}}
    <title>Laporan Produk PDF</title> {{-- Judul halaman PDF --}}
    <style>
        body {
            font-family: Arial, sans-serif; /* Mengatur font utama halaman */
            font-size: 12px; /* Ukuran font standar */
        }
        table {
            width: 100%; /* Lebar tabel memenuhi lebar halaman */
            border-collapse: collapse; /* Menggabungkan border tabel */
            margin-top: 1rem; /* Jarak atas tabel */
        }
        th, td {
            border: 1px solid #333; /* Border tabel berwarna abu gelap */
            padding: 6px; /* Jarak dalam sel tabel */
            text-align: left; /* Rata kiri teks dalam sel */
        }
        th {
            background-color: #f2f2f2; /* Warna latar header tabel */
        }
        h1 {
            text-align: center; /* Judul rata tengah */
            font-size: 18px; /* Ukuran font judul */
            margin-bottom: 0; /* Margin bawah nol */
        }
        p {
            text-align: center; /* Paragraf rata tengah */
            margin-top: 0; /* Margin atas nol */
            margin-bottom: 1rem; /* Margin bawah 1 rem */
        }
    </style>
</head>
<body>
    <h1>Laporan Produk</h1> {{-- Judul utama laporan --}}
    <p>Ringkasan dan daftar lengkap produk.</p> {{-- Deskripsi singkat laporan --}}
    <table>
        <thead>
            <tr>
                <th>No</th> {{-- Kolom nomor urut --}}
                <th>Nama Produk</th> {{-- Kolom nama produk --}}
                <th>SKU</th> {{-- Kolom kode unik produk --}}
                <th>Kategori</th> {{-- Kolom kategori produk --}}
                <th>Jumlah</th> {{-- Kolom jumlah stok --}}
                <th>Harga Beli</th> {{-- Kolom harga beli produk --}}
                <th>Supplier</th> {{-- Kolom nama supplier --}}
                <th>Status</th> {{-- Kolom status stok --}}
            </tr>
        </thead>
        <tbody>
            @foreach($produks as $index => $produk) {{-- Perulangan data produk --}}
            <tr>
                <td>{{ $index + 1 }}</td> {{-- Menampilkan nomor urut --}}
                <td>{{ $produk->nama_produk }}</td> {{-- Menampilkan nama produk --}}
                <td>{{ $produk->sku }}</td> {{-- Menampilkan SKU --}}
                <td>{{ $produk->kategori }}</td> {{-- Menampilkan kategori --}}
                <td>{{ $produk->jumlah }}</td> {{-- Menampilkan jumlah stok --}}
                <td>Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</td> {{-- Menampilkan harga beli dengan format Rupiah --}}
                <td>{{ $produk->supplier }}</td> {{-- Menampilkan nama supplier --}}
                <td>
                    @if($produk->jumlah <= 0) {{-- Jika stok habis --}}
                        Habis
                    @elseif($produk->jumlah <= 10) {{-- Jika stok rendah --}}
                        Stok Rendah
                    @else {{-- Jika stok tersedia --}}
                        Tersedia
                    @endif
                </td>
            </tr>
            @endforeach {{-- Akhir perulangan --}}
        </tbody>
    </table>
</body>
</html>
