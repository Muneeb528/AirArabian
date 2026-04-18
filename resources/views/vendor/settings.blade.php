@extends('layouts.vendor')
@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
<div class="vp-page-header">
    <div>
        <div class="vp-page-title">Agency Settings</div>
        <div class="vp-page-subtitle">Manage your agency information and branding</div>
    </div>
</div>

<form method="POST" action="{{ route('vendor.settings.update') }}" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
        {{-- Agency Info Card --}}
        <div class="col-lg-7">
            <div class="vp-card">
                <div class="vp-card-header">
                    <i class="fas fa-building" style="color:var(--red)"></i>
                    <h5>Agency Information</h5>
                </div>
                <div class="vp-card-body">
                    <div class="vp-settings-grid">
                        <div class="vp-form-group">
                            <label class="vp-label">Agency Name <span class="req">*</span></label>
                            <input type="text" name="agency_name" class="vp-input @error('agency_name') is-invalid @enderror"
                                   placeholder="Al-Noor Travel & Tours"
                                   value="{{ old('agency_name', $settings['agency_name'] ?? '') }}" required>
                            @error('agency_name')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="vp-form-group">
                            <label class="vp-label">City <span class="req">*</span></label>
                            <input type="text" name="city" class="vp-input @error('city') is-invalid @enderror"
                                   placeholder="Karachi"
                                   value="{{ old('city', $settings['city'] ?? '') }}" required>
                            @error('city')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="vp-form-group">
                            <label class="vp-label">Email Address <span class="req">*</span></label>
                            <input type="email" name="email" class="vp-input @error('email') is-invalid @enderror"
                                   placeholder="info@agency.com"
                                   value="{{ old('email', $settings['email'] ?? '') }}" required>
                            @error('email')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="vp-form-group">
                            <label class="vp-label">Mobile Number <span class="req">*</span></label>
                            <input type="text" name="mobile" class="vp-input @error('mobile') is-invalid @enderror"
                                   placeholder="+92 300 0000000"
                                   value="{{ old('mobile', $settings['mobile'] ?? '') }}" required>
                            @error('mobile')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Logo Upload Card --}}
        <div class="col-lg-5">
            <div class="vp-card h-100">
                <div class="vp-card-header">
                    <i class="fas fa-image" style="color:var(--red)"></i>
                    <h5>Agency Logo</h5>
                </div>
                <div class="vp-card-body d-flex flex-column align-items-center justify-content-center" style="min-height:200px">
                    @php $logo = $settings['logo'] ?? null; @endphp
                    @if($logo)
                        <img src="{{ asset('storage/'.$logo) }}" alt="Logo" class="vp-logo-preview mb-3" id="logoPreview"
                             style="max-height:90px;border-radius:10px;box-shadow:var(--shadow)">
                    @else
                        <div id="logoPreview" style="width:90px;height:90px;border-radius:50%;background:var(--red-light);display:flex;align-items:center;justify-content:center;margin-bottom:16px">
                            <i class="fas fa-image" style="font-size:2rem;color:var(--red)"></i>
                        </div>
                    @endif

                    <label for="logo" class="vp-logo-upload-area w-100" style="cursor:pointer">
                        <i class="fas fa-cloud-upload-alt" style="font-size:1.6rem;color:var(--red);display:block;margin-bottom:8px"></i>
                        <div style="font-weight:600;font-size:.9rem;color:var(--gray-700)">Click to upload logo</div>
                        <div style="font-size:.75rem;color:var(--gray-400);margin-top:4px">PNG, JPG, SVG — max 2MB</div>
                        <input type="file" name="logo" id="logo" accept="image/*" style="display:none"
                               onchange="previewLogo(this)">
                    </label>
                    @error('logo')<div class="vp-invalid-feedback mt-2">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-3 mt-4">
        <button type="submit" class="btn-vp-primary">
            <i class="fas fa-save"></i> Save Settings
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
function previewLogo(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var prev = document.getElementById('logoPreview');
            if (prev.tagName === 'IMG') {
                prev.src = e.target.result;
            } else {
                var img = document.createElement('img');
                img.id = 'logoPreview';
                img.src = e.target.result;
                img.style.cssText = 'max-height:90px;border-radius:10px;box-shadow:var(--shadow);margin-bottom:16px';
                prev.parentNode.replaceChild(img, prev);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
