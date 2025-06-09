<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Gudang Kita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root { --bs-primary: #4A69E2; --bs-font-sans-serif: 'Inter', sans-serif; }
        .auth-wrapper { background: #F7F8FC; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-card { max-width: 450px; width:100%; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1); border-radius: 1rem; }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="card auth-card p-4">
            <div class="card-body">
                <div class="text-center mb-4">
                    <h1 class="h2 fw-bold text-primary"><i class="fas fa-cubes-stacked me-2"></i>Gudang Kita</h1>
                    <p class="text-muted">Buat akun untuk mulai mengelola inventaris.</p>
                </div>

                <form action="{{ route('register') }}" method="POST">
                    <!-- FIRDAUS - tampilan error password harus minimal 8 digit -->
                    @if ($errors->any())
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <!-- FIRDAUS - end -->

                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="form-control form-control-lg" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control form-control-lg" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control form-control-lg" required>
                    </div>
                     <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold">Register</button>
                    </div>
                </form>
                <p class="mt-4 text-center text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold">Login di sini</a></p>
            </div>
        </div>
    </div>
</body>
</html>
