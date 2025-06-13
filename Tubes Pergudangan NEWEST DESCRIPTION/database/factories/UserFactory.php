<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * UserFactory adalah kelas factory yang digunakan untuk membuat data dummy atau contoh untuk model User.
 * Factory ini sangat berguna dalam pengujian (testing) dan seeding database.
 * 
 * Penjelasan lengkap per bagian:
 * 
 * 1. Namespace dan Import:
 * - Berada di namespace Database\Factories.
 * - Mengimpor kelas Factory dari Laravel untuk membuat factory model.
 * - Mengimpor Hash untuk meng-hash password.
 * - Mengimpor Str untuk membuat string acak.
 * 
 * 2. Deklarasi Kelas UserFactory:
 * - Meng-extend kelas Factory bawaan Laravel.
 * - Tipe model yang di-factory-kan adalah App\Models\User (dideklarasikan di phpdoc).
 * 
 * 3. Properti Static $password:
 * - Menyimpan password yang sudah di-hash agar tidak perlu di-hash berulang kali saat membuat banyak data dummy.
 * - Bertipe nullable string.
 * 
 * 4. Metode definition():
 * - Mendefinisikan state default data dummy untuk model User.
 * - Mengembalikan array atribut user dengan nilai dummy:
 *   - 'name': nama acak menggunakan faker.
 *   - 'email': email unik dan aman menggunakan faker.
 *   - 'email_verified_at': waktu verifikasi email saat ini.
 *   - 'password': password yang sudah di-hash, default 'password'.
 *   - 'remember_token': token acak untuk fitur "remember me".
 * 
 * 5. Metode unverified():
 * - Mendefinisikan state khusus untuk user yang emailnya belum terverifikasi.
 * - Mengembalikan instance factory dengan atribut 'email_verified_at' bernilai null.
 * 
 * Fungsi utama UserFactory adalah memudahkan pembuatan data user palsu untuk keperluan testing dan pengisian awal database.
 */
class UserFactory extends Factory
{
    /**
     * Password saat ini yang digunakan oleh factory.
     */
    protected static ?string $password;

    /**
     * Mendefinisikan state default model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Menandai bahwa alamat email model belum terverifikasi.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
