@extends('layouts.admin')
@section('title', 'Vendors — Admin')
@section('page-title', 'Vendors')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">Vendor Applications</h4>
    <div class="d-flex gap-2">
        <span class="mini-stat-card">Pending: <strong class="text-warning">{{ \App\Models\Vendor::where('status','pending')->count() }}</strong></span>
        <span class="mini-stat-card">Approved: <strong class="text-success">{{ \App\Models\Vendor::where('status','approved')->count() }}</strong></span>
    </div>
</div>

<div class="filter-bar mb-4">
    <form action="{{ route('admin.vendors.index') }}" method="GET" class="row g-2 align-items-end">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control custom-input" placeholder="Search by company or email..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="status" class="form-control custom-input">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn-admin-secondary w-100"><i class="fas fa-filter me-1"></i>Filter</button>
        </div>
    </form>
</div>

<div class="admin-table-card">
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Company</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Applied</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendors as $vendor)
                <tr>
                    <td>{{ $vendor->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="table-avatar"><i class="fas fa-building"></i></div>
                            <div>
                                <div class="fw-semibold">{{ $vendor->company_name }}</div>
                                @if($vendor->address)<small class="text-muted">{{ $vendor->address }}</small>@endif
                            </div>
                        </div>
                    </td>
                    <td>{{ $vendor->phone }}</td>
                    <td>{{ $vendor->email }}</td>
                    <td>
                        <span class="status-badge status-{{ $vendor->status }}">{{ ucfirst($vendor->status) }}</span>
                    </td>
                    <td>{{ $vendor->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.vendors.show', $vendor) }}" class="action-btn action-view" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($vendor->isPending())
                            <form method="POST" action="{{ route('admin.vendors.approve', $vendor) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="action-btn action-approve" title="Approve">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.vendors.reject', $vendor) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="action-btn action-delete" title="Reject" onclick="return confirm('Reject this vendor?')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4 text-muted">No vendors found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $vendors->withQueryString()->links() }}</div>
</div>
@endsection
