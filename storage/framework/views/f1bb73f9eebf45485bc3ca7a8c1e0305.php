<?php $__env->startSection('title', 'Admin Login — AirArabian'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-page">
    <div class="auth-bg"></div>
    <div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
        <div class="auth-card">
            <div class="auth-card-header text-center">
                <div class="auth-logo">
                    <i class="fas fa-plane"></i>
                </div>
                <h2 class="auth-title">Air<span class="gold-text">Arabian</span></h2>
                <p class="auth-subtitle">Admin Control Panel</p>
            </div>

            <div class="auth-card-body">
                <?php if(session('error')): ?>
                    <div class="alert alert-danger mb-4">
                        <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>
                <?php if(session('success')): ?>
                    <div class="alert alert-success mb-4">
                        <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('admin.login.post')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <div class="input-group-custom">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" id="email"
                                   class="form-control custom-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="admin@airarbian.com"
                                   value="<?php echo e(old('email')); ?>" required autofocus>
                        </div>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="input-group-custom">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" id="password"
                                   class="form-control custom-input"
                                   placeholder="••••••••" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye" id="password-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label for="remember" class="form-check-label text-muted">Remember me</label>
                        </div>
                    </div>

                    <button type="submit" class="btn-auth-submit w-100" id="login-btn">
                        <i class="fas fa-sign-in-alt me-2"></i>Login to Admin Panel
                    </button>
                </form>

                <div class="auth-divider">
                    <span>Other Portals</span>
                </div>

                <div class="text-center">
                    <a href="<?php echo e(route('vendor.login')); ?>" class="btn-auth-secondary">
                        <i class="fas fa-store me-2"></i>Vendor Login
                    </a>
                </div>
            </div>

            <div class="auth-card-footer text-center">
                <a href="<?php echo e(route('home')); ?>"><i class="fas fa-arrow-left me-1"></i>Back to Website</a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    const eye = document.getElementById(id + '-eye');
    if (input.type === 'password') {
        input.type = 'text';
        eye.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        eye.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\muneeb ahmed\Desktop\Travel_Portal\resources\views/admin/login.blade.php ENDPATH**/ ?>