@extends('layouts.admin')
@section('title', 'Bank Accounts')
@section('page-title', 'Bank Accounts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold"><i class="fas fa-university me-2 text-danger"></i>Bank Accounts</h4>
</div>

{{-- Add Bank Account Form --}}
<div class="admin-table-card mb-4">
    <div class="admin-table-header">
        <h5 class="mb-0">Add New Bank Account</h5>
    </div>
    <div class="p-4">
        <form method="POST" action="{{ route('admin.bank-accounts.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label fw-semibold small">Bank Name *</label>
                    <select name="bank_name" class="form-control custom-input" required>
                        <option value="">Select</option>
                        <option value="HBL">HBL</option>
                        <option value="BAFL">BAFL</option>
                        <option value="Meezan">Meezan</option>
                        <option value="FBL">FBL</option>
                        <option value="UBL">UBL</option>
                        <option value="MCB">MCB</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold small">Account Title *</label>
                    <input type="text" name="account_title" class="form-control custom-input"
                           placeholder="Account holder name" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold small">Account Number *</label>
                    <input type="text" name="account_number" class="form-control custom-input"
                           placeholder="0000-0000000-00" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold small">IBAN</label>
                    <input type="text" name="iban" class="form-control custom-input"
                           placeholder="PK00XXXX...">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold small">Branch</label>
                    <input type="text" name="branch" class="form-control custom-input"
                           placeholder="Branch name, City">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn-admin-primary w-100">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Bank Accounts Table --}}
<div class="admin-table-card">
    <div class="admin-table-header">
        <h5 class="mb-0">All Bank Accounts ({{ $banks->count() }})</h5>
    </div>
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>Bank</th>
                    <th>Account Title</th>
                    <th>Account Number</th>
                    <th>IBAN</th>
                    <th>Branch</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banks as $bank)
                <tr>
                    <td>
                        <span class="fw-bold" style="color:{{ $bank->bankColor() }}">
                            <i class="{{ $bank->bankIcon() }} me-1"></i>{{ $bank->bank_name }}
                        </span>
                    </td>
                    <td>{{ $bank->account_title }}</td>
                    <td><code>{{ $bank->account_number }}</code></td>
                    <td><small class="text-muted">{{ $bank->iban ?? '—' }}</small></td>
                    <td><small>{{ $bank->branch ?? '—' }}</small></td>
                    <td>
                        @if($bank->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.bank-accounts.destroy', $bank) }}"
                              onsubmit="return confirm('Delete this bank account?')" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-btn action-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">No bank accounts added yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
