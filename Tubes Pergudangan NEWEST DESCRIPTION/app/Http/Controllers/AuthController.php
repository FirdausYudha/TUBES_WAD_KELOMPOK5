<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * AuthController adalah controller yang mengatur proses autentikasi pengguna.
 * Controller ini menangani login, registrasi, autentikasi, dan logout pengguna.
 * 
 * Berikut penjelasan fungsi-fungsi utama di dalam controller ini:
 * 
 * - login(): Menampilkan halaman login.
 * - authenticate(Request $request): Memproses login dengan memvalidasi kredensial pengguna.
 *   Jika berhasil, mengarahkan ke halaman produk, jika gagal kembali ke login dengan pesan error.
 * - register(): Menampilkan halaman registrasi pengguna baru.
 * - store(Request $request): Memproses pendaftaran pengguna baru dengan validasi data dan penyimpanan ke database.
 * - logout(Request $request): Mengeluarkan pengguna dari sesi, menghapus sesi aktif, dan mengarahkan ke halaman login.
 * 
 * Controller ini menggunakan model User dan fitur Hash untuk keamanan password.
 */
class AuthController extends Controller
{
    /**
     * Menampilkan halaman login kepada pengguna.
     * Fungsi ini mengembalikan tampilan (view) 'auth.login'.
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Menangani proses autentikasi pengguna berdasarkan data form login (email dan password).
     * Memeriksa kredensial menggunakan Auth::attempt().
     * Jika berhasil, sesi pengguna diregenerasi dan diarahkan ke halaman '/produk'.
     * Jika gagal, kembali ke halaman login dengan pesan error "Email atau password salah."
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/produk'); // Redirect ke halaman produk
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Menampilkan halaman registrasi kepada pengguna.
     * Fungsi ini mengembalikan tampilan (view) 'auth.register'.
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Menangani penyimpanan data registrasi pengguna baru.
     * Memvalidasi input (nama, email, password) sesuai aturan.
     * Jika validasi berhasil, menyimpan data pengguna baru dengan password yang di-hash.
     * Setelah berhasil, diarahkan ke halaman login dengan pesan sukses.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    /**
     * Menangani proses logout pengguna.
     * Mengeluarkan pengguna dari sesi autentikasi, menghapus sesi aktif, dan meregenerasi token CSRF.
     * Setelah logout, diarahkan ke halaman login.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

}
