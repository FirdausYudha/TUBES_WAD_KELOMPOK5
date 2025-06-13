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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
