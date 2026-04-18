@extends('layouts.admin')

@section('title', 'Manage Tickets — Admin')
@section('page-title', 'Tickets')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <h4 class="mb-0 fw-bold">All Tickets</h4>
    <a href="{{ route('admin.tickets.create') }}" class="btn-admin-primary">
        <i class="fas fa-plus me-2"></i>Add New Ticket
    </a>
</div>

<!-- Filters -->
<div class="filter-bar mb-4">
    <form action="{{ route('admin.tickets.index') }}" method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control custom-input" placeholder="Search tickets..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="category" class="form-control custom-input">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-control custom-input">
                <option value="">All Statuses</option>
                <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
                <option value="booked" {{ request('status') === 'booked' ? 'selected' : '' }}>Booked</option>
                <option value="hold" {{ request('status') === 'hold' ? 'selected' : '' }}>On Hold</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn-admin-secondary w-100"><i class="fas fa-filter me-1"></i>Filter</button>
        </div>
    </form>
</div>

<!-- Tickets Table -->
<div class="admin-table-card">
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ticket</th>
                    <th>Category</th>
                    <th>Route</th>
                    <th>Price</th>
                    <th>Seats</th>
                    <th>Departure</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>
                        <div class="fw-semibold">{{ $ticket->title }}</div>
                        <small class="text-muted">{{ $ticket->airline }}</small>
                    </td>
                    <td><span class="category-pill category-{{ strtolower($ticket->category) }}">{{ $ticket->category }}</span></td>
                    <td>{{ $ticket->origin }} → {{ $ticket->destination }}</td>
                    <td class="fw-semibold gold-text">PKR {{ number_format($ticket->price) }}</td>
                    <td>
                        <span class="{{ $ticket->seats_available > 0 ? 'text-success' : 'text-danger' }}">
                            {{ $ticket->seats_available }}
                        </span>
                    </td>
                    <td>{{ $ticket->departure_date->format('d M Y') }}</td>
                    <td>
                        <span class="status-badge status-{{ $ticket->status }}">{{ ucfirst($ticket->status) }}</span>
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.tickets.edit', $ticket) }}" class="action-btn action-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.tickets.toggle-status', $ticket) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="action-btn action-toggle" title="Toggle Status">
                                    <i class="fas fa-{{ $ticket->status === 'available' ? 'ban' : 'check-circle' }}"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.tickets.destroy', $ticket) }}"
                                  onsubmit="return confirm('Delete this ticket permanently?')" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn action-delete" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-muted">
                        <i class="fas fa-ticket-alt fa-2x mb-2 d-block"></i>No tickets found. <a href="{{ route('admin.tickets.create') }}">Add the first one</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $tickets->withQueryString()->links() }}</div>
</div>
@endsection
