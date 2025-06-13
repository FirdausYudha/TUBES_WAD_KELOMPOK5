<?php

/**
 * File ini adalah entry point utama aplikasi Laravel.
 * 
 * Penjelasan lengkap per bagian:
 * 
 * 1. Definisi konstanta LARAVEL_START:
 * - Menyimpan waktu mulai eksekusi script untuk keperluan profiling dan debugging.
 * 
 * 2. Pengecekan mode maintenance:
 * - Jika file maintenance.php ada di folder storage/framework, maka aplikasi akan menampilkan halaman maintenance.
 * 
 * 3. Autoload Composer:
 * - Memuat autoloader Composer untuk meng-handle autoloading kelas PHP.
 * 
 * 4. Bootstrap aplikasi Laravel:
 * - Memuat bootstrap/app.php yang menginisialisasi aplikasi Laravel dan service container.
 * 
 * 5. Menangani request HTTP:
 * - Mengambil request HTTP saat ini menggunakan Request::capture().
 * - Memproses request melalui kernel aplikasi dan mengirimkan response ke browser.
 * 
 * Fungsi utama file ini adalah sebagai front controller yang menerima semua request HTTP dan mengarahkan ke aplikasi Laravel untuk diproses.
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
