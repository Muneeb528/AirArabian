@extends('layouts.admin')

@section('title', 'Bookings')

@section('content')
<div class="content-header">
    <h1>All Bookings</h1>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Ticket</th>
                <th>Vendor</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
            <tr>
                <td>{{ $booking->id }}</td>
                <td>{{ $booking->customer_name }}</td>
                <td>{{ $booking->ticket->title ?? 'N/A' }}</td>
                <td>{{ $booking->vendor->user->name ?? 'N/A' }}</td>
                <td>{{ $booking->status }}</td>
                <td>{{ $booking->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">No bookings found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection