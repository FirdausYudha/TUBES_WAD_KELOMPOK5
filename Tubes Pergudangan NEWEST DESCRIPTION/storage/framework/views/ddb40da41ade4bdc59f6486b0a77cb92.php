<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gudang Kita</title>
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
                    <p class="text-muted">Selamat datang kembali! Silakan login.</p>
                </div>
                
                <?php if(session('success')): ?>
                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                <?php endif; ?>
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                         Email atau password salah.
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('login')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control form-control-lg" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control form-control-lg" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold">Login</button>
                    </div>
                </form>
                <p class="mt-4 text-center text-muted">Belum punya akun? <a href="<?php echo e(route('register')); ?>" class="fw-bold">Daftar sekarang</a></p>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\egiag\Downloads\Tubes Pergudangan\Tubes Pergudangan\resources\views/auth/login.blade.php ENDPATH**/ ?>