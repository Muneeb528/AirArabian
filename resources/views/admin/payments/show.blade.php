@extends('layouts.admin')
@section('title', 'Payment Detail — Admin')
@section('page-title', 'Payment Detail')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">Payment #{{ $payment->id }}</h4>
    <a href="{{ route('admin.payments.index') }}" class="btn-admin-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="admin-form-card">
            <h5 class="mb-4"><i class="fas fa-credit-card me-2 gold-text"></i>Payment Info</h5>
            <table class="table info-table">
                <tr><td class="text-muted">Status</td><td><span class="status-badge status-{{ $payment->status }}">{{ ucfirst($payment->status) }}</span></td></tr>
                <tr><td class="text-muted">Method</td><td><span class="method-badge method-{{ $payment->method }}">{{ ucfirst($payment->method) }}</span></td></tr>
                <tr><td class="text-muted">Amount</td><td class="fw-bold gold-text">PKR {{ number_format($payment->amount) }}</td></tr>
                <tr><td class="text-muted">Transaction ID</td><td>{{ $payment->transaction_id ?? '—' }}</td></tr>
                <tr><td class="text-muted">Submitted</td><td>{{ $payment->created_at->format('d M Y, h:i A') }}</td></tr>
                @if($payment->admin_note)
                <tr><td class="text-muted">Admin Note</td><td class="text-danger">{{ $payment->admin_note }}</td></tr>
                @endif
            </table>

            <h6 class="mt-3 mb-2"><i class="fas fa-book me-2 gold-text"></i>Booking Info</h6>
            <table class="table info-table">
                <tr><td class="text-muted">Booking #</td><td>{{ $payment->booking_id }}</td></tr>
                <tr><td class="text-muted">Customer</td><td>{{ $payment->booking->customer_name }}</td></tr>
                <tr><td class="text-muted">Phone</td><td>{{ $payment->booking->customer_phone }}</td></tr>
                <tr><td class="text-muted">Ticket</td><td>{{ $payment->booking->ticket->title ?? '—' }}</td></tr>
                <tr><td class="text-muted">Vendor</td><td>{{ $payment->booking->vendor->company_name ?? '—' }}</td></tr>
            </table>

            @if($payment->isPending())
            <div class="d-flex gap-2 mt-4">
                <form method="POST" action="{{ route('admin.payments.approve', $payment) }}" class="flex-grow-1">
                    @csrf
                    <button class="btn-admin-primary w-100" onclick="return confirm('Approve this payment? This will confirm the booking.')">
                        <i class="fas fa-check-circle me-2"></i>Approve Payment
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.payments.reject', $payment) }}" class="flex-grow-1">
                    @csrf
                    <input type="hidden" name="admin_note" value="Payment proof not verified.">
                    <button class="btn-admin-danger w-100" onclick="return confirm('Reject this payment?')">
                        <i class="fas fa-times-circle me-2"></i>Reject
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>

    <div class="col-lg-7">
        <div class="admin-form-card">
            <h5 class="mb-4"><i class="fas fa-image me-2 gold-text"></i>Payment Proof Screenshot</h5>
            @if($payment->proof_image)
                <div class="proof-image-container">
                    <img src="{{ Storage::url($payment->proof_image) }}" class="proof-full-image" alt="Payment Proof">
                    <div class="mt-3">
                        <a href="{{ Storage::url($payment->proof_image) }}" target="_blank" class="btn-admin-secondary">
                            <i class="fas fa-external-link-alt me-2"></i>Open Full Size
                        </a>
                    </div>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-image fa-3x mb-3 d-block"></i>
                    No proof image submitted
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
