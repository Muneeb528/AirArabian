<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Register — Travel Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/vendor-portal.css') }}" rel="stylesheet">
</head>
<body class="vp-body">
<div class="vp-auth-page">
    <div class="vp-auth-card vp-auth-card-wide">
        <div class="vp-auth-top">
            <div class="vp-auth-icon"><i class="fas fa-store"></i></div>
            <div class="vp-auth-title">Create Vendor Account</div>
            <div class="vp-auth-subtitle">Register to start booking travel packages</div>
        </div>

        <div class="vp-auth-body">
            @if($errors->any())
                <div class="vp-alert vp-alert-error mb-4">
                    <div>
                        <i class="fas fa-exclamation-circle"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-1 ps-3" style="font-size:.82rem">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('vendor.register.post') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="vp-form-group">
                            <label class="vp-label">Your Full Name <span class="req">*</span></label>
                            <input type="text" name="name" class="vp-input @error('name') is-invalid @enderror"
                                   placeholder="Muhammad Ali" value="{{ old('name') }}" required>
                            @error('name')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="vp-form-group">
                            <label class="vp-label">Company / Agency Name <span class="req">*</span></label>
                            <input type="text" name="company_name" class="vp-input @error('company_name') is-invalid @enderror"
                                   placeholder="Al-Noor Travels" value="{{ old('company_name') }}" required>
                            @error('company_name')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="vp-form-group">
                            <label class="vp-label">Email Address <span class="req">*</span></label>
                            <input type="email" name="email" class="vp-input @error('email') is-invalid @enderror"
                                   placeholder="info@company.com" value="{{ old('email') }}" required>
                            @error('email')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="vp-form-group">
                            <label class="vp-label">Phone / Mobile <span class="req">*</span></label>
                            <input type="text" name="phone" class="vp-input @error('phone') is-invalid @enderror"
                                   placeholder="+92 300 0000000" value="{{ old('phone') }}" required>
                            @error('phone')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="vp-form-group">
                            <label class="vp-label">Address</label>
                            <input type="text" name="address" class="vp-input"
                                   placeholder="City, Province, Pakistan" value="{{ old('address') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="vp-form-group">
                            <label class="vp-label">Password <span class="req">*</span></label>
                            <input type="password" name="password" class="vp-input @error('password') is-invalid @enderror"
                                   placeholder="Min 8 characters" required>
                            @error('password')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="vp-form-group">
                            <label class="vp-label">Confirm Password <span class="req">*</span></label>
                            <input type="password" name="password_confirmation" class="vp-input"
                                   placeholder="Repeat password" required>
                        </div>
                    </div>
                </div>

                <div style="background:var(--red-pale);border-radius:10px;padding:12px 16px;margin:16px 0;font-size:.8rem;color:#C53030">
                    <i class="fas fa-info-circle me-1"></i>
                    Your account will be reviewed by admin before activation. You'll be notified once approved.
                </div>

                <button type="submit" class="btn-vp-primary w-100 justify-content-center py-3">
                    <i class="fas fa-user-plus"></i> Register Account
                </button>
            </form>

            <div class="vp-auth-divider">Already have an account?</div>

            <a href="{{ route('vendor.login') }}" class="btn-vp-secondary w-100 justify-content-center">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </a>
        </div>

        <div class="vp-auth-footer">
            <a href="{{ route('home') }}"><i class="fas fa-arrow-left me-1"></i>Back to Website</a>
        </div>
    </div>
</div>
</body>
</html>
