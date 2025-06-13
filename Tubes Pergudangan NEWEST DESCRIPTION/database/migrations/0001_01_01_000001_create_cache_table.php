<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration ini bertugas membuat tabel-tabel untuk sistem cache aplikasi.
 * 
 * Penjelasan lengkap per bagian:
 * 
 * 1. Kelas Anonymous Migration:
 * - Meng-extend kelas Migration bawaan Laravel.
 * - Memiliki dua metode utama: up() untuk menjalankan migrasi, down() untuk rollback.
 * 
 * 2. Metode up():
 * - Membuat tabel 'cache' dengan kolom:
 *   - key: primary key string, sebagai kunci cache.
 *   - value: nilai cache, bertipe mediumText untuk menyimpan data cukup besar.
 *   - expiration: waktu kedaluwarsa cache dalam bentuk integer (timestamp).
 * 
 * - Membuat tabel 'cache_locks' untuk mengelola kunci cache:
 *   - key: primary key string, kunci yang dikunci.
 *   - owner: pemilik kunci, string.
 *   - expiration: waktu kedaluwarsa kunci, integer.
 * 
 * 3. Metode down():
 * - Menghapus kedua tabel jika migrasi di-rollback.
 * 
 * Fungsi utama migrasi ini adalah menyiapkan struktur database untuk menyimpan data cache dan mengelola kunci cache agar sinkron dan aman.
 */
return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
