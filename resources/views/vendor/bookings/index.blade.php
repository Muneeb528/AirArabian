@extends('layouts.vendor')
@section('title', 'My Ticket Bookings')
@section('page-title', 'My Ticket Bookings')

@section('content')
<div class="vp-page-header">
    <div>
        <div class="vp-page-title">My Ticket Bookings</div>
        <div class="vp-page-subtitle">Manage and track all your travel bookings</div>
    </div>
    <a href="{{ route('vendor.bookings.new') }}" class="btn-vp-primary">
        <i class="fas fa-plus"></i> New Booking
    </a>
</div>

{{-- STATUS FILTER PILLS --}}
<div class="vp-filter-pills">
    @foreach($statuses as $val => $label)
        <a href="{{ route('vendor.bookings.index', array_filter(['status' => $val])) }}"
           class="vp-pill {{ request('status', '') === $val ? 'active' : '' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="vp-table-card">
    <div class="vp-table-head">
        <h5><i class="fas fa-ticket-alt" style="color:var(--red);margin-right:8px"></i>Bookings List</h5>
        <span style="font-size:.8rem;color:var(--gray-400)">{{ $bookings->total() }} booking(s)</span>
    </div>

    <div class="table-responsive">
        <table class="vp-table">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>PNR</th>
                    <th>Group</th>
                    <th>Category</th>
                    <th>Dates</th>
                    <th>Adults</th>
                    <th>Children</th>
                    <th>Amount</th>
                    <th>Payment Due</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>
                        <div style="font-weight:700;font-size:.82rem;color:var(--red)">{{ $booking->invoice_number }}</div>
                        <div style="font-size:.75rem;color:var(--gray-400)">{{ $booking->created_at->format('d M Y') }}</div>
                    </td>
                    <td>
                        <span style="font-family:monospace;font-weight:600;font-size:.85rem">
                            {{ $booking->pnr ?? '—' }}
                        </span>
                    </td>
                    <td>
                        <div style="font-size:.85rem;max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                            {{ $booking->group_name ?? '—' }}
                        </div>
                    </td>
                    <td>
                        <span style="background:var(--red-light);color:var(--red-dark);padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;white-space:nowrap">
                            {{ $booking->category ?? '—' }}
                        </span>
                    </td>
                    <td style="font-size:.82rem;white-space:nowrap">
                        @if($booking->travel_date)
                            <div><i class="fas fa-plane-departure" style="color:var(--red);font-size:.7rem"></i> {{ $booking->travel_date->format('d M Y') }}</div>
                        @endif
                        @if($booking->return_date)
                            <div><i class="fas fa-plane-arrival" style="color:var(--gray-400);font-size:.7rem"></i> {{ $booking->return_date->format('d M Y') }}</div>
                        @endif
                        @if(!$booking->travel_date) — @endif
                    </td>
                    <td style="text-align:center;font-weight:600">{{ $booking->adults ?? $booking->passenger_count ?? 1 }}</td>
                    <td style="text-align:center;font-weight:600">{{ $booking->children ?? 0 }}</td>
                    <td style="font-weight:700;color:var(--red-dark);white-space:nowrap">
                        PKR {{ number_format($booking->total_amount) }}
                    </td>
                    <td>
                        @if($booking->payment_deadline)
                            @php $expired = now()->isAfter($booking->payment_deadline); @endphp
                            <span class="vp-timer {{ $expired ? 'expired' : '' }}" data-deadline="{{ $booking->payment_deadline->toISOString() }}">
                                <i class="fas fa-clock"></i>
                                <span class="countdown-text">
                                    {{ $expired ? 'Expired' : $booking->payment_deadline->diffForHumans() }}
                                </span>
                            </span>
                        @else
                            <span style="color:var(--gray-400);font-size:.8rem">—</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $badgeMap = [
                                'hold'         => 'vp-badge-hold',
                                'partial_sold' => 'vp-badge-partial',
                                'confirmed'    => 'vp-badge-confirmed',
                                'cancelled'    => 'vp-badge-cancelled',
                                'pending'      => 'vp-badge-pending',
                            ];
                            $labelMap = [
                                'hold'         => 'Hold',
                                'partial_sold' => 'Partial Sold',
                                'confirmed'    => 'Confirmed',
                                'cancelled'    => 'Canceled',
                                'pending'      => 'Pending',
                            ];
                        @endphp
                        <span class="vp-badge {{ $badgeMap[$booking->status] ?? 'vp-badge-pending' }}">
                            {{ $labelMap[$booking->status] ?? ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('vendor.bookings.show', $booking) }}" class="btn-vp-icon view" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(in_array($booking->status, ['hold','pending']))
                            <form method="POST" action="{{ route('vendor.bookings.destroy', $booking) }}"
                                  onsubmit="return confirm('Cancel this booking?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-vp-icon del" title="Cancel">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" style="text-align:center;padding:48px;color:var(--gray-400)">
                        <i class="fas fa-ticket-alt" style="font-size:2.5rem;margin-bottom:12px;display:block;opacity:.3"></i>
                        No bookings found.
                        <a href="{{ route('vendor.bookings.new') }}" style="color:var(--red);font-weight:600;text-decoration:none;margin-left:6px">Create your first booking →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($bookings->hasPages())
        <div style="padding:16px 20px;border-top:1px solid var(--gray-100)">
            {{ $bookings->withQueryString()->links() }}
        </div>
    @endif
</div>

@push('scripts')
<script>
// Live countdown timers
document.querySelectorAll('.vp-timer[data-deadline]').forEach(function(el) {
    var deadline = new Date(el.getAttribute('data-deadline'));
    var textEl = el.querySelector('.countdown-text');

    function update() {
        var now = new Date();
        var diff = deadline - now;
        if (diff <= 0) {
            el.classList.add('expired');
            textEl.textContent = 'Expired';
            return;
        }
        var h = Math.floor(diff / 3600000);
        var m = Math.floor((diff % 3600000) / 60000);
        var s = Math.floor((diff % 60000) / 1000);
        textEl.textContent = h + 'h ' + m + 'm ' + s + 's';
    }

    update();
    setInterval(update, 1000);
});
</script>
@endpush
@endsection
