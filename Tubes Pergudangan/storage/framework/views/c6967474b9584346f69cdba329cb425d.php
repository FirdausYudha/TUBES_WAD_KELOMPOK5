
<?php $__env->startSection('title', 'Register'); ?>
<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="card shadow-sm rounded-3 auth-card">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="fa-solid fa-user-plus fa-3x text-primary mb-3"></i>
                <h2 class="card-title fw-bold">Buat Akun Baru</h2>
                <p class="text-muted">Daftar untuk mulai mengelola inventaris Anda</p>
            </div>

            <form action="<?php echo e(route('register')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" id="name" class="form-control" required placeholder="Nama Lengkap Anda">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required placeholder="nama@email.com">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required placeholder="Minimal 8 karakter">
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Ulangi password">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Register</button>
                </div>
            </form>

            <p class="mt-4 text-center text-muted">Sudah punya akun? <a href="<?php echo e(route('login')); ?>">Login di sini</a></p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Tubes Pergudangan\resources\views/auth/register.blade.php ENDPATH**/ ?>