@extends('layouts.vendor')
@section('title', 'Vendor Dashboard')
@section('page-title', 'Dashboard')
@section('content')

<!-- Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card stat-card-blue">
            <div class="stat-card-icon"><i class="fas fa-book-open"></i></div>
            <div class="stat-card-info">
                <div class="stat-card-number">{{ $stats['total_bookings'] }}</div>
                <div class="stat-card-label">Total Bookings</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card stat-card-gold">
            <div class="stat-card-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-card-info">
                <div class="stat-card-number">{{ $stats['pending_bookings'] }}</div>
                <div class="stat-card-label">Pending</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card stat-card-green">
            <div class="stat-card-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-card-info">
                <div class="stat-card-number">{{ $stats['confirmed_bookings'] }}</div>
                <div class="stat-card-label">Confirmed</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card stat-card-purple">
            <div class="stat-card-icon"><i class="fas fa-money-bill-wave"></i></div>
            <div class="stat-card-info">
                <div class="stat-card-number">PKR {{ number_format($stats['total_spent']) }}</div>
                <div class="stat-card-label">Total Spent</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Available Tickets -->
    <div class="col-lg-7">
        <div class="admin-table-card">
            <div class="admin-table-header">
                <h5 class="mb-0"><i class="fas fa-ticket-alt me-2 gold-text"></i>Available Tickets</h5>
            </div>
            <div class="table-responsive">
                <table class="table admin-table">
                    <thead>
                        <tr><th>Ticket</th><th>Route</th><th>Category</th><th>Price</th><th>Seats</th><th>Departure</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        @forelse($availableTickets as $ticket)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $ticket->title }}</div>
                                <small class="text-muted">{{ $ticket->airline }}</small>
                            </td>
                            <td>{{ $ticket->origin }} → {{ $ticket->destination }}</td>
                            <td><span class="category-pill category-{{ strtolower($ticket->category) }}">{{ $ticket->category }}</span></td>
                            <td class="gold-text fw-semibold">PKR {{ number_format($ticket->price) }}</td>
                            <td>{{ $ticket->seats_available }}</td>
                            <td>{{ $ticket->departure_date->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('vendor.bookings.create', $ticket) }}" class="btn-mini-action">
                                    <i class="fas fa-plus me-1"></i>Book
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-3">No tickets available right now</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="col-lg-5">
        <div class="admin-table-card">
            <div class="admin-table-header">
                <h5 class="mb-0"><i class="fas fa-history me-2 gold-text"></i>Recent Bookings</h5>
                <a href="{{ route('vendor.bookings.index') }}" class="btn-view-all">View All</a>
            </div>
            @forelse($recentBookings as $booking)
            <div class="pending-item">
                <div class="pending-avatar"><i class="fas fa-user"></i></div>
                <div class="flex-grow-1 min-w-0">
                    <div class="fw-semibold text-truncate">{{ $booking->customer_name }}</div>
                    <small class="text-muted">{{ $booking->ticket->title ?? '—' }} · PKR {{ number_format($booking->total_amount) }}</small>
                </div>
                <span class="status-badge status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
            </div>
            @empty
            <div class="text-center text-muted py-4 small">No bookings yet. Start by booking a ticket!</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
