<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Produk merepresentasikan entitas produk dalam aplikasi.
 * Model ini berhubungan dengan tabel 'produks' di database.
 * 
 * Properti:
 * - $table: Nama tabel di database yang digunakan model ini.
 * - $fillable: Daftar atribut yang dapat diisi secara massal (mass assignment).
 * 
 * Atribut yang dapat diisi:
 * - nama_produk: Nama produk.
 * - kategori: Kategori produk.
 * - jumlah: Jumlah stok produk.
 * - harga_beli: Harga beli produk.
 * - supplier: Nama supplier produk.
 * - sku: Stock Keeping Unit, kode unik produk.
 * 
 * Model ini digunakan untuk melakukan operasi CRUD pada data produk.
 */
class Produk extends Model
{
    protected $table = 'produks'; // Nama tabel (bisa disesuaikan)

    protected $fillable = [
        'nama_produk',
        'kategori',
        'jumlah',
        'harga_beli',
        'supplier',
        'sku',
    ];
}
