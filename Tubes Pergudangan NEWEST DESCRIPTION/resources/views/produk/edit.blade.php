<!-- {{--
File ini adalah halaman form untuk mengedit data produk yang sudah ada di inventaris.
Berikut penjelasan lengkap per bagian:

1. Extends dan Section:
- Meng-extends layout utama aplikasi.
- Menentukan judul halaman menjadi "Edit Produk".
- Membuka section content untuk isi halaman.

2. Bagian header halaman:
- Container fleksibel dengan judul halaman "Edit Produk".
- Menampilkan deskripsi dengan nama produk yang sedang diedit.
- Tombol "Kembali" untuk kembali ke halaman daftar produk.

3. Form edit produk:
- Form dengan method POST ke route 'produk.update' dengan parameter ID produk.
- Menggunakan @csrf untuk proteksi CSRF.
- Menggunakan @method('PUT') untuk mengirimkan request PUT.
- Input form untuk:
  * Nama Produk (text, wajib diisi, sudah terisi data lama)
  * SKU (Kode Unik Produk, text, wajib diisi, sudah terisi data lama)
  * Kategori (text, wajib diisi, sudah terisi data lama)
  * Jumlah Stok (number, wajib diisi, minimal 0, sudah terisi data lama)
  * Harga Beli (number, wajib diisi, minimal 0, sudah terisi data lama) dengan prefix "Rp"
  * Nama Supplier (text, wajib diisi, sudah terisi data lama)
- Semua input menggunakan class Bootstrap form-control.
- Form diatur dalam grid responsif.

4. Tombol submit:
- Tombol "Update Perubahan" dengan ikon simpan.
- Tombol berada di kanan bawah form.

Fungsi utama file ini adalah menyediakan UI yang mudah digunakan untuk memperbarui data produk yang sudah ada di sistem inventaris.
--}} -->

@extends('layout')
@section('title', 'Edit Produk')
@section('content')

{{-- Bagian header halaman --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-0">Edit Produk</h1>
        <p class="text-muted">Perbarui data untuk produk: <strong class="text-dark">{{ $produk->nama_produk }}</strong></p>
    </div>
     <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
</div>

{{-- Form edit produk --}}
<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('produk.update', $produk->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-4">
                {{-- Input nama produk --}}
                <div class="col-md-12">
                    <label for="nama_produk" class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="{{ $produk->nama_produk }}" required>
                </div>
                {{-- Input SKU --}}
                <div class="col-md-6">
                    <label for="sku" class="form-label">SKU (Kode Unik Produk)</label>
                    <input type="text" name="sku" id="sku" class="form-control" value="{{ $produk->sku }}" required>
                </div>
                {{-- Input kategori --}}
                <div class="col-md-6">
                    <label for="kategori" class="form-label">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control" value="{{ $produk->kategori }}" required>
                </div>
                {{-- Input jumlah stok --}}
                 <div class="col-md-6">
                    <label for="jumlah" class="form-label">Jumlah Stok</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ $produk->jumlah }}" required min="0">
                </div>
                {{-- Input harga beli --}}
                <div class="col-md-6">
                    <label for="harga_beli" class="form-label">Harga Beli</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="harga_beli" id="harga_beli" class="form-control" value="{{ $produk->harga_beli }}" required min="0">
                    </div>
                </div>
                {{-- Input nama supplier --}}
                <div class="col-md-12">
                    <label for="supplier" class="form-label">Nama Supplier</label>
                    <input type="text" name="supplier" id="supplier" class="form-control" value="{{ $produk->supplier }}" required>
                </div>
            </div>
            {{-- Tombol submit --}}
            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-2"></i> Update Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
