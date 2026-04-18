@extends('layouts.vendor')
@section('title', 'Booking — ' . $booking->invoice_number)
@section('page-title', 'Booking Detail')

@section('content')
<div class="vp-page-header">
    <div>
        <div class="vp-page-title">Booking Detail</div>
        <div class="vp-page-subtitle">{{ $booking->invoice_number }}</div>
    </div>
    <a href="{{ route('vendor.bookings.index') }}" class="btn-vp-secondary btn-vp-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to Bookings
    </a>
</div>

<div class="row g-4">
    {{-- Main Details --}}
    <div class="col-lg-8">
        <div class="vp-card mb-4">
            <div class="vp-card-header">
                <i class="fas fa-file-invoice" style="color:var(--red)"></i>
                <h5>Booking Information</h5>
                @php
                    $badgeMap = ['hold'=>'vp-badge-hold','partial_sold'=>'vp-badge-partial','confirmed'=>'vp-badge-confirmed','cancelled'=>'vp-badge-cancelled','pending'=>'vp-badge-pending'];
                    $labelMap = ['hold'=>'Hold','partial_sold'=>'Partial Sold','confirmed'=>'Confirmed','cancelled'=>'Canceled','pending'=>'Pending'];
                @endphp
                <span class="vp-badge {{ $badgeMap[$booking->status] ?? 'vp-badge-pending' }} ms-auto">
                    {{ $labelMap[$booking->status] ?? ucfirst($booking->status) }}
                </span>
            </div>
            <div class="vp-card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div style="font-size:.72rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Invoice #</div>
                        <div style="font-weight:700;color:var(--red)">{{ $booking->invoice_number }}</div>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size:.72rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Category</div>
                        <div style="font-weight:600">{{ $booking->category ?? '—' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size:.72rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">PNR</div>
                        <div style="font-weight:600;font-family:monospace">{{ $booking->pnr ?? '—' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size:.72rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Group</div>
                        <div style="font-weight:600">{{ $booking->group_name ?? '—' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size:.72rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Travel Date</div>
                        <div style="font-weight:600">{{ $booking->travel_date ? $booking->travel_date->format('d M Y') : '—' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size:.72rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Return Date</div>
                        <div style="font-weight:600">{{ $booking->return_date ? $booking->return_date->format('d M Y') : '—' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size:.72rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Adults</div>
                        <div style="font-weight:600">{{ $booking->adults ?? $booking->passenger_count ?? 1 }}</div>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size:.72rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Children</div>
                        <div style="font-weight:600">{{ $booking->children ?? 0 }}</div>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size:.72rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Total Amount</div>
                        <div style="font-weight:800;font-size:1.1rem;color:var(--red)">PKR {{ number_format($booking->total_amount) }}</div>
                    </div>
                </div>

                @if($booking->notes)
                <div style="margin-top:20px;padding-top:16px;border-top:1px solid var(--gray-100)">
                    <div style="font-size:.72rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px">Notes</div>
                    <div style="font-size:.88rem;color:var(--gray-700)">{{ $booking->notes }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Passenger --}}
        <div class="vp-card">
            <div class="vp-card-header">
                <i class="fas fa-user" style="color:var(--red)"></i>
                <h5>Lead Passenger</h5>
            </div>
            <div class="vp-card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div style="font-size:.72rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Name</div>
                        <div style="font-weight:600">{{ $booking->customer_name }}</div>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size:.72rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Phone</div>
                        <div style="font-weight:600">{{ $booking->customer_phone }}</div>
                    </div>
                    <div class="col-md-4">
                        <div style="font-size:.72rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Email</div>
                        <div style="font-weight:600">{{ $booking->customer_email ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="col-lg-4">
        {{-- Payment Deadline --}}
        @if($booking->payment_deadline && in_array($booking->status, ['hold','pending']))
        <div class="vp-card mb-4" style="border:2px solid {{ now()->isAfter($booking->payment_deadline) ? 'var(--red)' : '#F6AD55' }}">
            <div class="vp-card-body text-center" style="padding:24px">
                <div style="font-size:1.8rem;margin-bottom:8px">⏰</div>
                <div style="font-weight:700;font-size:.9rem;margin-bottom:4px;color:var(--gray-900)">Payment Deadline</div>
                <div style="font-size:1.1rem;font-weight:800;color:{{ now()->isAfter($booking->payment_deadline) ? 'var(--red)' : '#C05621' }}"
                     id="deadline-display">
                    {{ $booking->payment_deadline->format('d M Y, h:i A') }}
                </div>
                <div class="vp-timer mt-3 mx-auto" id="timer" data-deadline="{{ $booking->payment_deadline->toISOString() }}"
                     style="display:inline-flex">
                    <i class="fas fa-clock"></i>
                    <span class="countdown-text">Calculating...</span>
                </div>
                <div style="margin-top:14px">
                    <a href="{{ route('vendor.bank-accounts') }}" class="btn-vp-primary btn-vp-sm">
                        <i class="fas fa-university"></i> View Bank Accounts
                    </a>
                </div>
            </div>
        </div>
        @endif

        {{-- Actions --}}
        <div class="vp-card">
            <div class="vp-card-header">
                <i class="fas fa-bolt" style="color:var(--red)"></i>
                <h5>Actions</h5>
            </div>
            <div class="vp-card-body d-flex flex-column gap-2">
                @if(in_array($booking->status, ['hold','pending']))
                <form method="POST" action="{{ route('vendor.bookings.destroy', $booking) }}"
                      onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-vp-secondary w-100 justify-content-center"
                            style="color:var(--red);border-color:var(--red-light)">
                        <i class="fas fa-times-circle"></i> Cancel Booking
                    </button>
                </form>
                @endif
                <a href="{{ route('vendor.bookings.index') }}" class="btn-vp-secondary w-100 justify-content-center">
                    <i class="fas fa-list"></i> All Bookings
                </a>
                <a href="{{ route('vendor.bookings.new') }}" class="btn-vp-primary w-100 justify-content-center">
                    <i class="fas fa-plus"></i> New Booking
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
var timer = document.getElementById('timer');
if (timer) {
    var deadline = new Date(timer.getAttribute('data-deadline'));
    var textEl = timer.querySelector('.countdown-text');
    function update() {
        var diff = deadline - new Date();
        if (diff <= 0) {
            timer.classList.add('expired');
            textEl.textContent = 'Expired';
            return;
        }
        var h = Math.floor(diff / 3600000);
        var m = Math.floor((diff % 3600000) / 60000);
        var s = Math.floor((diff % 60000) / 1000);
        textEl.textContent = h + 'h ' + m + 'm ' + s + 's remaining';
    }
    update();
    setInterval(update, 1000);
}
</script>
@endpush
@endsection
