<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gudang Kita</title>
    <!-- Menghubungkan Bootstrap CSS untuk styling responsif -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menghubungkan Google Fonts Inter untuk tipografi -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Menghubungkan Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style> 
        /* Mengatur warna utama dan font default */
        :root { --bs-primary: #4A69E2; --bs-font-sans-serif: 'Inter', sans-serif; }
        /* Styling untuk pembungkus halaman otentikasi agar konten berada di tengah */
        .auth-wrapper { background: #F7F8FC; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        /* Styling kartu form login dengan bayangan dan sudut membulat */
        .auth-card { max-width: 450px; width:100%; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1); border-radius: 1rem; }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="card auth-card p-4">
            <div class="card-body">
                <!-- Bagian header dengan judul aplikasi dan ikon -->
                <div class="text-center mb-4">
                    <h1 class="h2 fw-bold text-primary"><i class="fas fa-cubes-stacked me-2"></i>Gudang Kita</h1>
                    <p class="text-muted">Selamat datang kembali! Silakan login.</p>
                </div>
                
                <!-- Menampilkan pesan sukses jika ada -->
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <!-- Menampilkan pesan error jika ada kesalahan login -->
                @if($errors->any())
                    <div class="alert alert-danger">
                         Email atau password salah.
                    </div>
                @endif

                <!-- Form login pengguna -->
                <form action="{{ route('login') }}" method="POST">
                    @csrf <!-- Token CSRF untuk keamanan form -->
                    <!-- Input Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control form-control-lg" required>
                    </div>
                    <!-- Input Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control form-control-lg" required>
                    </div>
                    <!-- Tombol Submit Login -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold">Login</button>
                    </div>
                </form>
                <!-- Link untuk pengguna yang belum punya akun -->
                <p class="mt-4 text-center text-muted">Belum punya akun? <a href="{{ route('register') }}" class="fw-bold">Daftar sekarang</a></p>
            </div>
        </div>
    </div>
</body>
</html>

<!--
Halaman login ini adalah tampilan untuk pengguna melakukan autentikasi ke aplikasi "Gudang Kita".
Fungsi utama halaman ini adalah menyediakan form input email dan password untuk login.

Penjelasan isi kode per bagian:
- Bagian <head>:
  - Mendefinisikan metadata halaman seperti charset dan viewport.
  - Mengimpor stylesheet Bootstrap, font Inter, dan ikon Font Awesome untuk styling.
  - Mendefinisikan style khusus untuk layout halaman login agar tampil responsif dan menarik.

- Bagian <body>:
  - Membungkus seluruh konten dalam div dengan kelas 'auth-wrapper' untuk mengatur posisi tengah layar.
  - Card dengan kelas 'auth-card' berisi form login dengan padding dan bayangan.
  - Judul aplikasi dengan ikon dan pesan sambutan.
  - Menampilkan pesan sukses jika ada (misal setelah registrasi berhasil).
  - Menampilkan pesan error jika ada kesalahan input login.
  - Form login menggunakan metode POST ke route 'login' dengan proteksi CSRF.
  - Input email dan password wajib diisi.
  - Tombol submit untuk mengirim data login.
  - Tautan ke halaman registrasi bagi pengguna yang belum punya akun.

Halaman ini penting untuk mengamankan akses aplikasi hanya untuk pengguna terdaftar.
-->

<!--
Halaman login ini adalah tampilan untuk pengguna melakukan autentikasi ke aplikasi "Gudang Kita".
Fungsi utama halaman ini adalah menyediakan form input email dan password untuk login.

Penjelasan isi kode:
- Menggunakan Bootstrap dan font Inter untuk styling yang responsif dan modern.
- Bagian utama halaman dibungkus dalam div dengan kelas 'auth-wrapper' untuk mengatur layout tengah layar.
- Terdapat judul aplikasi dengan ikon dan pesan sambutan.
- Menampilkan pesan sukses jika ada (misal setelah registrasi berhasil).
- Menampilkan pesan error jika ada kesalahan input login.
- Form login menggunakan metode POST ke route 'login' dengan proteksi CSRF.
- Input email dan password wajib diisi.
- Tombol submit untuk mengirim data login.
- Tautan ke halaman registrasi bagi pengguna yang belum punya akun.

Halaman ini penting untuk mengamankan akses aplikasi hanya untuk pengguna terdaftar.
-->
