@extends('layouts.vendor')
@section('title', 'Create Booking — ' . $category)
@section('page-title', 'Create Booking')

@section('content')
<div class="vp-page-header">
    <div>
        <div class="vp-page-title">
            New Booking
            <span style="background:var(--red);color:#fff;font-size:.7rem;padding:3px 12px;border-radius:20px;font-weight:600;margin-left:8px;vertical-align:middle">
                {{ $category }}
            </span>
        </div>
        <div class="vp-page-subtitle">Fill in the passenger and travel details below</div>
    </div>
    <a href="{{ route('vendor.bookings.new') }}" class="btn-vp-secondary btn-vp-sm">
        <i class="fas fa-arrow-left me-1"></i> Change Category
    </a>
</div>

{{-- 4-hour notice --}}
<div style="background:#FEEBC8;border:1px solid #F6AD55;border-radius:10px;padding:12px 18px;margin-bottom:24px;display:flex;align-items:center;gap:10px;font-size:.85rem;color:#744210">
    <i class="fas fa-clock" style="font-size:1.1rem;color:#C05621"></i>
    <strong>Note:</strong> After creating this booking, payment must be submitted within <strong>4 hours</strong> or the booking will be automatically cancelled.
</div>

<div class="vp-card">
    <div class="vp-card-header">
        <i class="fas fa-file-alt" style="color:var(--red)"></i>
        <h5>Booking Details</h5>
    </div>
    <div class="vp-card-body">
        <form method="POST" action="{{ route('vendor.bookings.store') }}">
            @csrf
            <input type="hidden" name="category" value="{{ $category }}">

            <div class="row g-3">
                {{-- Group / PNR --}}
                <div class="col-md-6">
                    <div class="vp-form-group">
                        <label class="vp-label">PNR (Booking Reference)</label>
                        <input type="text" name="pnr" class="vp-input @error('pnr') is-invalid @enderror"
                               placeholder="e.g. ABC123" value="{{ old('pnr') }}">
                        @error('pnr')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="vp-form-group">
                        <label class="vp-label">Group Name</label>
                        <input type="text" name="group_name" class="vp-input @error('group_name') is-invalid @enderror"
                               placeholder="e.g. Group A — Karachi" value="{{ old('group_name') }}">
                        @error('group_name')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Lead Passenger --}}
                <div class="col-12">
                    <div style="font-size:.82rem;font-weight:700;color:var(--gray-600);text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid var(--gray-100);padding-bottom:8px;margin-bottom:4px">
                        Lead Passenger
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="vp-form-group">
                        <label class="vp-label">Full Name <span class="req">*</span></label>
                        <input type="text" name="customer_name" class="vp-input @error('customer_name') is-invalid @enderror"
                               placeholder="Muhammad Ahmed" value="{{ old('customer_name') }}" required>
                        @error('customer_name')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="vp-form-group">
                        <label class="vp-label">Phone <span class="req">*</span></label>
                        <input type="text" name="customer_phone" class="vp-input @error('customer_phone') is-invalid @enderror"
                               placeholder="+92 300 0000000" value="{{ old('customer_phone') }}" required>
                        @error('customer_phone')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="vp-form-group">
                        <label class="vp-label">Email</label>
                        <input type="email" name="customer_email" class="vp-input @error('customer_email') is-invalid @enderror"
                               placeholder="passenger@email.com" value="{{ old('customer_email') }}">
                        @error('customer_email')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Passengers --}}
                <div class="col-12">
                    <div style="font-size:.82rem;font-weight:700;color:var(--gray-600);text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid var(--gray-100);padding-bottom:8px;margin-bottom:4px">
                        Passengers
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="vp-form-group">
                        <label class="vp-label">Adults <span class="req">*</span></label>
                        <input type="number" name="adults" class="vp-input @error('adults') is-invalid @enderror"
                               placeholder="1" value="{{ old('adults', 1) }}" min="1" required>
                        @error('adults')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="vp-form-group">
                        <label class="vp-label">Children</label>
                        <input type="number" name="children" class="vp-input @error('children') is-invalid @enderror"
                               placeholder="0" value="{{ old('children', 0) }}" min="0">
                        @error('children')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Dates --}}
                <div class="col-md-3">
                    <div class="vp-form-group">
                        <label class="vp-label">Travel Date <span class="req">*</span></label>
                        <input type="date" name="travel_date" class="vp-input @error('travel_date') is-invalid @enderror"
                               value="{{ old('travel_date') }}" required>
                        @error('travel_date')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="vp-form-group">
                        <label class="vp-label">Return Date</label>
                        <input type="date" name="return_date" class="vp-input @error('return_date') is-invalid @enderror"
                               value="{{ old('return_date') }}">
                        @error('return_date')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Amount --}}
                <div class="col-md-4">
                    <div class="vp-form-group">
                        <label class="vp-label">Total Amount (PKR) <span class="req">*</span></label>
                        <input type="number" name="total_amount" class="vp-input @error('total_amount') is-invalid @enderror"
                               placeholder="50000" value="{{ old('total_amount') }}" min="0" step="1" required>
                        @error('total_amount')<div class="vp-invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Notes --}}
                <div class="col-12">
                    <div class="vp-form-group">
                        <label class="vp-label">Notes / Remarks</label>
                        <textarea name="notes" class="vp-textarea" placeholder="Any special requirements or notes...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3 mt-2">
                <button type="submit" class="btn-vp-primary">
                    <i class="fas fa-check-circle"></i> Create Booking
                </button>
                <a href="{{ route('vendor.bookings.new') }}" class="btn-vp-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
