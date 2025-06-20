<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration ini bertugas membuat tabel-tabel untuk sistem antrian pekerjaan (jobs) di aplikasi.
 * 
 * Penjelasan lengkap per bagian:
 * 
 * 1. Kelas Anonymous Migration:
 * - Meng-extend kelas Migration bawaan Laravel.
 * - Memiliki dua metode utama: up() untuk menjalankan migrasi, down() untuk rollback.
 * 
 * 2. Metode up():
 * - Membuat tabel 'jobs' dengan kolom:
 *   - id: primary key auto increment.
 *   - queue: nama antrian, diindeks.
 *   - payload: data pekerjaan dalam bentuk teks panjang.
 *   - attempts: jumlah percobaan eksekusi pekerjaan.
 *   - reserved_at: waktu pekerjaan dipesan, nullable.
 *   - available_at: waktu pekerjaan tersedia.
 *   - created_at: waktu pembuatan pekerjaan.
 * 
 * - Membuat tabel 'job_batches' untuk mengelola batch pekerjaan:
 *   - id: primary key string.
 *   - name: nama batch.
 *   - total_jobs: total pekerjaan dalam batch.
 *   - pending_jobs: pekerjaan yang belum selesai.
 *   - failed_jobs: pekerjaan yang gagal.
 *   - failed_job_ids: daftar ID pekerjaan yang gagal.
 *   - options: opsi tambahan, nullable.
 *   - cancelled_at: waktu batch dibatalkan, nullable.
 *   - created_at: waktu pembuatan batch.
 *   - finished_at: waktu batch selesai, nullable.
 * 
 * - Membuat tabel 'failed_jobs' untuk menyimpan pekerjaan yang gagal:
 *   - id: primary key auto increment.
 *   - uuid: UUID unik pekerjaan.
 *   - connection: koneksi database atau queue.
 *   - queue: nama antrian.
 *   - payload: data pekerjaan.
 *   - exception: pesan error atau exception.
 *   - failed_at: timestamp saat gagal, default current timestamp.
 * 
 * 3. Metode down():
 * - Menghapus ketiga tabel jika migrasi di-rollback.
 * 
 * Fungsi utama migrasi ini adalah menyiapkan struktur database untuk manajemen antrian pekerjaan, batch pekerjaan, dan pencatatan pekerjaan yang gagal.
 */
return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        // Membuat tabel 'jobs' untuk menyimpan antrian pekerjaan
        Schema::create('jobs', function (Blueprint $table) {
            $table->id(); // Kolom id sebagai primary key auto increment
            $table->string('queue')->index(); // Nama antrian, diindeks untuk pencarian cepat
            $table->longText('payload'); // Data pekerjaan dalam format teks panjang
            $table->unsignedTinyInteger('attempts'); // Jumlah percobaan eksekusi pekerjaan
            $table->unsignedInteger('reserved_at')->nullable(); // Waktu pekerjaan dipesan, nullable
            $table->unsignedInteger('available_at'); // Waktu pekerjaan tersedia untuk diproses
            $table->unsignedInteger('created_at'); // Waktu pembuatan pekerjaan
        });

        // Membuat tabel 'job_batches' untuk mengelola batch pekerjaan
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary(); // ID batch sebagai primary key string
            $table->string('name'); // Nama batch pekerjaan
            $table->integer('total_jobs'); // Total pekerjaan dalam batch
            $table->integer('pending_jobs'); // Jumlah pekerjaan yang belum selesai
            $table->integer('failed_jobs'); // Jumlah pekerjaan yang gagal
            $table->longText('failed_job_ids'); // Daftar ID pekerjaan yang gagal dalam batch
            $table->mediumText('options')->nullable(); // Opsi tambahan, nullable
            $table->integer('cancelled_at')->nullable(); // Waktu batch dibatalkan, nullable
            $table->integer('created_at'); // Waktu pembuatan batch
            $table->integer('finished_at')->nullable(); // Waktu batch selesai, nullable
        });

        // Membuat tabel 'failed_jobs' untuk menyimpan pekerjaan yang gagal
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id(); // Kolom id sebagai primary key auto increment
            $table->string('uuid')->unique(); // UUID unik untuk setiap pekerjaan gagal
            $table->text('connection'); // Koneksi database atau queue yang digunakan
            $table->text('queue'); // Nama antrian pekerjaan
            $table->longText('payload'); // Data pekerjaan yang gagal
            $table->longText('exception'); // Pesan error atau exception yang terjadi
            $table->timestamp('failed_at')->useCurrent(); // Timestamp saat pekerjaan gagal, default current timestamp
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        // Menghapus tabel 'jobs' jika rollback migrasi
        Schema::dropIfExists('jobs');
        // Menghapus tabel 'job_batches' jika rollback migrasi
        Schema::dropIfExists('job_batches');
        // Menghapus tabel 'failed_jobs' jika rollback migrasi
        Schema::dropIfExists('failed_jobs');
    }
};
