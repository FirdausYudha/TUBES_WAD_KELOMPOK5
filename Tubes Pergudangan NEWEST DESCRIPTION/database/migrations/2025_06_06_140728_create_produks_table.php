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
        // Membuat tabel 'produks' dengan kolom-kolom yang diperlukan
        Schema::create('produks', function (Blueprint $table) {
            $table->id(); // Kolom id sebagai primary key auto increment
            $table->string('nama_produk'); // Kolom nama_produk untuk menyimpan nama produk
            $table->string('kategori'); // Kolom kategori untuk menyimpan kategori produk
            $table->integer('jumlah'); // Kolom jumlah untuk menyimpan stok produk
            $table->decimal('harga_beli', 15, 2); // Kolom harga_beli untuk menyimpan harga beli produk dengan presisi 15,2
            $table->string('supplier'); // Kolom supplier untuk menyimpan nama supplier produk
            $table->string('sku')->unique(); // Kolom sku sebagai kode unik produk (Stock Keeping Unit)
            $table->timestamps(); // Kolom created_at dan updated_at otomatis
        });
    }


    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        // Menghapus tabel 'produks' jika migrasi di-rollback
        Schema::dropIfExists('produks');
    }
};
