<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration ini bertugas membuat tabel 'produks' yang menyimpan data produk dalam aplikasi.
 * 
 * Penjelasan lengkap per bagian:
 * 
 * 1. Kelas Anonymous Migration:
 * - Meng-extend kelas Migration bawaan Laravel.
 * - Memiliki dua metode utama: up() untuk menjalankan migrasi, down() untuk rollback.
 * 
 * 2. Metode up():
 * - Membuat tabel 'produks' dengan kolom:
 *   - id: primary key auto increment.
 *   - nama_produk: nama produk, tipe string.
 *   - kategori: kategori produk, tipe string.
 *   - jumlah: jumlah stok produk, tipe integer.
 *   - harga_beli: harga beli produk, tipe decimal dengan presisi 15,2.
 *   - supplier: nama supplier produk, tipe string.
 *   - sku: kode unik produk (Stock Keeping Unit), tipe string dan unik.
 *   - timestamps: kolom created_at dan updated_at otomatis.
 * 
 * 3. Metode down():
 * - Menghapus tabel 'produks' jika migrasi di-rollback.
 * 
 * Fungsi utama migrasi ini adalah menyiapkan struktur database untuk menyimpan data produk yang digunakan dalam manajemen inventaris.
 */
return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->string('kategori');
            $table->integer('jumlah');
            $table->decimal('harga_beli', 15, 2);
            $table->string('supplier');
            $table->string('sku')->unique();
            $table->timestamps();
        });
    }


    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
