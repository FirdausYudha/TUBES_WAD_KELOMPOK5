<!-- {{--
File ini adalah halaman form untuk menambahkan produk baru ke dalam inventaris.
Berikut penjelasan lengkap per bagian:

1. Extends dan Section:
- Meng-extends layout utama aplikasi.
- Menentukan judul halaman menjadi "Tambah Produk".
- Membuka section content untuk isi halaman.

2. Bagian header halaman:
- Container fleksibel dengan judul halaman "Tambah Produk Baru".
- Deskripsi singkat di bawah judul.
- Tombol "Kembali" untuk kembali ke halaman daftar produk.

3. Form tambah produk:
- Form dengan method POST ke route 'produk.store'.
- Token CSRF untuk keamanan form.
- Input form untuk:
  * Nama Produk (text, wajib diisi)
  * SKU (Kode Unik Produk, text, wajib diisi)
  * Kategori (text, wajib diisi)
  * Jumlah Stok Awal (number, wajib diisi, minimal 0)
  * Harga Beli (number, wajib diisi, minimal 0) dengan prefix "Rp"
  * Nama Supplier (text, wajib diisi)
- Semua input menggunakan class Bootstrap form-control.
- Form diatur dalam grid responsif.

4. Tombol submit:
- Tombol "Simpan Produk" dengan ikon simpan.
- Tombol berada di kanan bawah form.

Fungsi utama file ini adalah menyediakan UI yang mudah digunakan untuk memasukkan data produk baru ke sistem inventaris.
--}} -->

@extends('layout')
@section('title', 'Tambah Produk')
@section('content')

{{-- Bagian header halaman --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-0">Tambah Produk Baru</h1>
        <p class="text-muted">Isi formulir di bawah untuk menambahkan produk ke inventaris.</p>
    </div>
     <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
</div>

{{-- Form tambah produk --}}
<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('produk.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                {{-- Input nama produk --}}
                <div class="col-md-12">
                    <label for="nama_produk" class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" class="form-control" required>
                </div>
                {{-- Input SKU --}}
                <div class="col-md-6">
                    <label for="sku" class="form-label">SKU (Kode Unik Produk)</label>
                    <input type="text" name="sku" id="sku" class="form-control" required>
                </div>
                {{-- Input kategori --}}
                <div class="col-md-6">
                    <label for="kategori" class="form-label">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" required>
                </div>
                {{-- Input jumlah stok awal --}}
                 <div class="col-md-6">
                    <label for="jumlah" class="form-label">Jumlah Stok Awal</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" required min="0">
                </div>
                {{-- Input harga beli --}}
                <div class="col-md-6">
                    <label for="harga_beli" class="form-label">Harga Beli</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="harga_beli" id="harga_beli" class="form-control" required min="0">
                    </div>
                </div>
                {{-- Input nama supplier --}}
                <div class="col-md-12">
                    <label for="supplier" class="form-label">Nama Supplier</label>
                    <input type="text" name="supplier" id="supplier" class="form-control" required>
                </div>
            </div>
            {{-- Tombol submit --}}
            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-2"></i> Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
