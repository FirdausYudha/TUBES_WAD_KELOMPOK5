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
            $table->id(); // Membuat kolom id sebagai primary key auto increment
            $table->string('name'); // Kolom nama pengguna bertipe string
            $table->string('email')->unique(); // Kolom email pengguna, harus unik
            $table->timestamp('email_verified_at')->nullable(); // Timestamp verifikasi email, boleh kosong
            $table->string('password'); // Kolom password terenkripsi
            $table->rememberToken(); // Token untuk fitur "remember me"
            $table->timestamps(); // Kolom created_at dan updated_at otomatis
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Kolom email sebagai primary key
            $table->string('token'); // Token reset password
            $table->timestamp('created_at')->nullable(); // Waktu pembuatan token, boleh kosong
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Kolom id sebagai primary key string
            $table->foreignId('user_id')->nullable()->index(); // Foreign key ke tabel users, nullable dan diindeks
            $table->string('ip_address', 45)->nullable(); // Alamat IP pengguna, boleh kosong
            $table->text('user_agent')->nullable(); // Informasi user agent browser, boleh kosong
            $table->longText('payload'); // Data sesi dalam bentuk teks panjang
            $table->integer('last_activity')->index(); // Waktu aktivitas terakhir, diindeks
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('users'); // Menghapus tabel users jika ada
        Schema::dropIfExists('password_reset_tokens'); // Menghapus tabel password_reset_tokens jika ada
        Schema::dropIfExists('sessions'); // Menghapus tabel sessions jika ada
    }
};
