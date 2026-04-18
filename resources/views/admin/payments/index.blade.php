@extends('layouts.admin')
@section('title', 'Payments — Admin')
@section('page-title', 'Payments')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">Payment Verifications</h4>
</div>

<div class="filter-bar mb-4">
    <form action="{{ route('admin.payments.index') }}" method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <select name="status" class="form-control custom-input">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status')==='pending'?'selected':'' }}>Pending</option>
                <option value="approved" {{ request('status')==='approved'?'selected':'' }}>Approved</option>
                <option value="rejected" {{ request('status')==='rejected'?'selected':'' }}>Rejected</option>
            </select>
        </div>
        <div class="col-md-4">
            <select name="method" class="form-control custom-input">
                <option value="">All Methods</option>
                <option value="jazzcash" {{ request('method')==='jazzcash'?'selected':'' }}>JazzCash</option>
                <option value="easypaisa" {{ request('method')==='easypaisa'?'selected':'' }}>EasyPaisa</option>
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn-admin-secondary w-100"><i class="fas fa-filter me-1"></i>Filter</button>
        </div>
    </form>
</div>

<div class="admin-table-card">
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr><th>#</th><th>Vendor</th><th>Booking #</th><th>Method</th><th>Amount</th><th>Proof</th><th>Submitted</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->booking->vendor->company_name ?? '—' }}</td>
                    <td>#{{ $payment->booking_id }}</td>
                    <td>
                        <span class="method-badge method-{{ $payment->method }}">
                            <i class="fas fa-mobile-alt me-1"></i>{{ ucfirst($payment->method) }}
                        </span>
                    </td>
                    <td class="fw-semibold gold-text">PKR {{ number_format($payment->amount) }}</td>
                    <td>
                        @if($payment->proof_image)
                            <a href="{{ Storage::url($payment->proof_image) }}" target="_blank" class="proof-thumb">
                                <img src="{{ Storage::url($payment->proof_image) }}" alt="Proof">
                                <span>View</span>
                            </a>
                        @else
                            <span class="text-muted small">No proof</span>
                        @endif
                    </td>
                    <td>{{ $payment->created_at->format('d M Y') }}<br><small class="text-muted">{{ $payment->created_at->diffForHumans() }}</small></td>
                    <td><span class="status-badge status-{{ $payment->status }}">{{ ucfirst($payment->status) }}</span></td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.payments.show', $payment) }}" class="action-btn action-view"><i class="fas fa-eye"></i></a>
                            @if($payment->isPending())
                            <form method="POST" action="{{ route('admin.payments.approve', $payment) }}" class="d-inline">
                                @csrf
                                <button class="action-btn action-approve" title="Approve" onclick="return confirm('Approve this payment?')"><i class="fas fa-check"></i></button>
                            </form>
                            <form method="POST" action="{{ route('admin.payments.reject', $payment) }}" class="d-inline">
                                @csrf
                                <button class="action-btn action-delete" title="Reject" onclick="return confirm('Reject this payment?')"><i class="fas fa-times"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-4 text-muted">No payments found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $payments->withQueryString()->links() }}</div>
</div>
@endsection
