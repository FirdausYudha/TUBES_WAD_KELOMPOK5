<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;

/**
 * File routes/web.php berisi definisi rute HTTP untuk aplikasi.
 * Rute menghubungkan URL dengan controller dan metode yang menangani permintaan.
 * 
 * Berikut penjelasan detail setiap bagian:
 * 
 * 1. Middleware 'auth':
 * - Semua rute di dalam grup ini hanya dapat diakses oleh user yang sudah login.
 * - Rute '/' mengarah ke halaman utama produk (ProdukController@index).
 * - Rute khusus laporan produk (laporan, laporanCsv, laporanPdf) didefinisikan di atas resource route.
 * - Rute untuk pengaturan aplikasi (SettingsController).
 * - Resource route untuk produk yang menyediakan CRUD otomatis.
 * 
 * 2. Rute publik:
 * - Rute login, register, dan logout yang dapat diakses tanpa login.
 * 
 * 3. Redirect:
 * - Rute '/home' diarahkan ke '/produk'.
 */

 // Hanya user yang login bisa akses route ini
Route::middleware('auth')->group(function () {
    Route::get('/', [ProdukController::class, 'index']);
    
    // ⚠️ PENTING: Route khusus HARUS di atas route resource!
    Route::get('produk/laporan', [ProdukController::class, 'laporan'])->name('produk.laporan');
    Route::get('produk/laporan/csv', [ProdukController::class, 'laporanCsv'])->name('produk.laporan.csv');
    Route::get('produk/laporan/pdf', [ProdukController::class, 'laporanPdf'])->name('produk.laporan.pdf');

    // Settings routes
    Route::get('settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [\App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
    
    // Route resource di bawah
    Route::resource('produk', ProdukController::class);

    // PDF export route for laporan
    Route::get('produk/laporan/pdf', [\App\Http\Controllers\ProdukController::class, 'laporanPdf'])->name('produk.laporan.pdf');
});

// Route publik (bisa diakses tanpa login)
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect /home ke /produk
Route::get('/home', function () {
    return redirect('/produk');
});
?>