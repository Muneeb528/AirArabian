<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Login — Travel Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/vendor-portal.css') }}" rel="stylesheet">
</head>
<body class="vp-body">
<div class="vp-auth-page">
    <div class="vp-auth-card">
        <div class="vp-auth-top">
            <div class="vp-auth-icon"><i class="fas fa-paper-plane"></i></div>
            <div class="vp-auth-title">Vendor Portal</div>
            <div class="vp-auth-subtitle">Sign in to manage your bookings</div>
        </div>

        <div class="vp-auth-body">
            @if(session('success'))
                <div class="vp-alert vp-alert-success mb-4">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="vp-alert vp-alert-error mb-4">
                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('vendor.login.post') }}">
                @csrf
                <div class="vp-form-group">
                    <label class="vp-label">Email Address <span class="req">*</span></label>
                    <input type="email" name="email" class="vp-input @error('email') is-invalid @enderror"
                           placeholder="vendor@company.com" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="vp-form-group">
                    <label class="vp-label">Password <span class="req">*</span></label>
                    <div style="position:relative">
                        <input type="password" name="password" id="pwd" class="vp-input"
                               placeholder="••••••••" required>
                        <button type="button" onclick="togglePwd()" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:#9CA3AF;cursor:pointer">
                            <i class="fas fa-eye" id="pwd-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <label class="d-flex align-items-center gap-2" style="cursor:pointer;font-size:.85rem;color:#4B5563">
                        <input type="checkbox" name="remember" style="accent-color:#E53E3E"> Remember me
                    </label>
                </div>

                <button type="submit" class="btn-vp-primary w-100 justify-content-center py-3">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>

            <div class="vp-auth-divider">or</div>

            <a href="{{ route('vendor.register') }}" class="btn-vp-secondary w-100 justify-content-center">
                <i class="fas fa-user-plus"></i> Create New Vendor Account
            </a>
        </div>

        <div class="vp-auth-footer">
            <a href="{{ route('home') }}"><i class="fas fa-arrow-left me-1"></i>Back to Website</a>
            &nbsp;·&nbsp;
            <a href="{{ route('admin.login') }}">Admin Login</a>
        </div>
    </div>
</div>
<script>
function togglePwd() {
    const p = document.getElementById('pwd');
    const i = document.getElementById('pwd-icon');
    p.type = p.type === 'password' ? 'text' : 'password';
    i.classList.toggle('fa-eye'); i.classList.toggle('fa-eye-slash');
}
</script>
</body>
</html>
