<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;

// Hanya user yang login bisa akses route ini
Route::middleware('auth')->group(function () {
    Route::get('/', [ProdukController::class, 'index']);
    Route::resource('produk', ProdukController::class);
});

// Route publik (bisa diakses tanpa login)
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect /home ke /mahasiswa (kalau memang dibutuhkan)
Route::get('/home', function () {
    return redirect('/produk');
});

?>
