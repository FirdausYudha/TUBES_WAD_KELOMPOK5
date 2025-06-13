<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration ini bertugas membuat tabel-tabel penting untuk manajemen user dan sesi di database.
 * 
 * Penjelasan lengkap per bagian:
 * 
 * 1. Kelas Anonymous Migration:
 * - Meng-extend kelas Migration bawaan Laravel.
 * - Memiliki dua metode utama: up() untuk menjalankan migrasi, down() untuk rollback.
 * 
 * 2. Metode up():
 * - Membuat tabel 'users' dengan kolom:
 *   - id: primary key auto increment.
 *   - name: nama pengguna, tipe string.
 *   - email: email pengguna, unik.
 *   - email_verified_at: timestamp verifikasi email, nullable.
 *   - password: password terenkripsi.
 *   - remember_token: token untuk fitur "remember me".
 *   - timestamps: kolom created_at dan updated_at otomatis.
 * 
 * - Membuat tabel 'password_reset_tokens' untuk menyimpan token reset password:
 *   - email: primary key, string.
 *   - token: token reset password.
 *   - created_at: waktu pembuatan token, nullable.
 * 
 * - Membuat tabel 'sessions' untuk menyimpan sesi login pengguna:
 *   - id: primary key string.
 *   - user_id: foreign key ke tabel users, nullable dan diindeks.
 *   - ip_address: alamat IP pengguna, nullable.
 *   - user_agent: informasi user agent browser, nullable.
 *   - payload: data sesi dalam bentuk teks panjang.
 *   - last_activity: waktu aktivitas terakhir, diindeks.
 * 
 * 3. Metode down():
 * - Menghapus ketiga tabel jika migrasi di-rollback.
 * 
 * Fungsi utama migrasi ini adalah menyiapkan struktur database yang diperlukan untuk autentikasi dan manajemen sesi pengguna.
 */
return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
