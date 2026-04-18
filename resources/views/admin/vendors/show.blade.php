@extends('layouts.admin')
@section('title', 'Vendor Details — Admin')
@section('page-title', 'Vendor Details')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">{{ $vendor->company_name }}</h4>
    <a href="{{ route('admin.vendors.index') }}" class="btn-admin-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Vendors
    </a>
</div>

<div class="row g-4">
    <!-- Vendor Info -->
    <div class="col-lg-5">
        <div class="admin-form-card">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="vendor-detail-avatar"><i class="fas fa-building"></i></div>
                <div>
                    <h5 class="mb-0">{{ $vendor->company_name }}</h5>
                    <span class="status-badge status-{{ $vendor->status }}">{{ ucfirst($vendor->status) }}</span>
                </div>
            </div>
            <table class="table info-table">
                <tr><td class="text-muted">Phone</td><td>{{ $vendor->phone }}</td></tr>
                <tr><td class="text-muted">Email</td><td>{{ $vendor->email }}</td></tr>
                <tr><td class="text-muted">Address</td><td>{{ $vendor->address ?? '—' }}</td></tr>
                <tr><td class="text-muted">Applied</td><td>{{ $vendor->created_at->format('d M Y, h:i A') }}</td></tr>
                @if($vendor->user)
                <tr><td class="text-muted">Login Email</td><td><code>{{ $vendor->user->email }}</code></td></tr>
                @endif
                @if($vendor->rejection_reason)
                <tr><td class="text-muted">Rejection Reason</td><td class="text-danger">{{ $vendor->rejection_reason }}</td></tr>
                @endif
            </table>

            <!-- Action Buttons -->
            @if($vendor->isPending())
            <div class="d-flex gap-2 mt-3">
                <form method="POST" action="{{ route('admin.vendors.approve', $vendor) }}" class="flex-grow-1">
                    @csrf
                    <button class="btn-admin-primary w-100"><i class="fas fa-check me-2"></i>Approve Vendor</button>
                </form>
                <form method="POST" action="{{ route('admin.vendors.reject', $vendor) }}" class="flex-grow-1">
                    @csrf
                    <input type="hidden" name="reason" value="Application does not meet requirements.">
                    <button class="btn-admin-danger w-100" onclick="return confirm('Reject this vendor?')">
                        <i class="fas fa-times me-2"></i>Reject
                    </button>
                </form>
            </div>
            @endif
        </div>

        <!-- Assign Credentials -->
        @if($vendor->isApproved())
        <div class="admin-form-card mt-4">
            <h5 class="mb-3"><i class="fas fa-key me-2 gold-text"></i>Assign Login Credentials</h5>
            <form method="POST" action="{{ route('admin.vendors.assign-credentials', $vendor) }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Login Email</label>
                    <input type="email" name="username" class="form-control custom-input"
                           placeholder="vendor@company.com"
                           value="{{ old('username', $vendor->user?->email) }}" required>
                    @error('username')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control custom-input" placeholder="Min 8 characters" required>
                    @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control custom-input" placeholder="Repeat password" required>
                </div>
                <button type="submit" class="btn-admin-primary w-100">
                    <i class="fas fa-save me-2"></i>{{ $vendor->user ? 'Update Credentials' : 'Create Login' }}
                </button>
            </form>
        </div>
        @endif
    </div>

    <!-- Booking History -->
    <div class="col-lg-7">
        <div class="admin-table-card">
            <div class="admin-table-header">
                <h5 class="mb-0"><i class="fas fa-history me-2 gold-text"></i>Booking History</h5>
                <span class="badge bg-primary">{{ $vendor->bookings->count() }} total</span>
            </div>
            <div class="table-responsive">
                <table class="table admin-table">
                    <thead>
                        <tr><th>#</th><th>Customer</th><th>Ticket</th><th>Amount</th><th>Status</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        @forelse($vendor->bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->customer_name }}</td>
                            <td class="text-truncate" style="max-width:130px;">{{ $booking->ticket->title ?? '—' }}</td>
                            <td>PKR {{ number_format($booking->total_amount) }}</td>
                            <td><span class="status-badge status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
                            <td>{{ $booking->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-3">No bookings yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
