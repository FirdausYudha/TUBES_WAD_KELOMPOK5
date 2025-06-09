
<?php $__env->startSection('title', 'Login'); ?>
<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="card shadow-sm rounded-3 auth-card">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="fa-solid fa-right-to-bracket fa-3x text-primary mb-3"></i>
                <h2 class="card-title fw-bold">Selamat Datang Kembali</h2>
                <p class="text-muted">Silakan login untuk melanjutkan</p>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <form action="<?php echo e(route('login')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required placeholder="nama@email.com">
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required placeholder="••••••••">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Login</button>
                </div>
            </form>

            <p class="mt-4 text-center text-muted">Belum punya akun? <a href="<?php echo e(route('register')); ?>">Daftar di sini</a></p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Tubes Pergudangan\resources\views/auth/login.blade.php ENDPATH**/ ?>