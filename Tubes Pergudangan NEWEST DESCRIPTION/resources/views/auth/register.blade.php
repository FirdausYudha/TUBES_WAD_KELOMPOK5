<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Gudang Kita</title>
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
        /* Styling kartu form registrasi dengan bayangan dan sudut membulat */
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
                    <p class="text-muted">Buat akun untuk mulai mengelola inventaris.</p>
                </div>

                <!-- Form registrasi pengguna -->
                <form action="{{ route('register') }}" method="POST">
                    @csrf <!-- Token CSRF untuk keamanan form -->
                    <!-- Input Nama Lengkap -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="form-control form-control-lg" required>
                    </div>
                    <!-- Input Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control form-control-lg" required>
                    </div>
                    <!-- Input Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control form-control-lg" required>
                    </div>
                    <!-- Input Konfirmasi Password -->
                     <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg" required>
                    </div>
                    <!-- Tombol Submit Registrasi -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold">Register</button>
                    </div>
                </form>
                <!-- Link untuk pengguna yang sudah punya akun -->
                <p class="mt-4 text-center text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold">Login di sini</a></p>
            </div>
        </div>
    </div>
</body>
</html>
