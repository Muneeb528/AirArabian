@extends('layouts.app')

@section('title', 'Admin Login — AirArabian')

@section('content')
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
                @if(session('error'))
                    <div class="alert alert-danger mb-4">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success mb-4">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.post') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <div class="input-group-custom">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" id="email"
                                   class="form-control custom-input @error('email') is-invalid @enderror"
                                   placeholder="admin@airarbian.com"
                                   value="{{ old('email') }}" required autofocus>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                        @enderror
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
                    <a href="{{ route('vendor.login') }}" class="btn-auth-secondary">
                        <i class="fas fa-store me-2"></i>Vendor Login
                    </a>
                </div>
            </div>

            <div class="auth-card-footer text-center">
                <a href="{{ route('home') }}"><i class="fas fa-arrow-left me-1"></i>Back to Website</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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
@endpush
