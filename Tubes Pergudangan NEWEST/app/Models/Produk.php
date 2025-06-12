<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
