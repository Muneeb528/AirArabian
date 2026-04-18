<?php

namespace App\Http\Controllers\VendorPortal;

use App\Http\Controllers\Controller;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendor;

        $stats = [
            'total_bookings'     => $vendor->bookings()->count(),
            'pending_bookings'   => $vendor->bookings()->where('status', 'pending')->count(),
            'confirmed_bookings' => $vendor->bookings()->where('status', 'confirmed')->count(),
            'total_spent'        => $vendor->bookings()
                ->whereHas('payment', fn($q) => $q->where('status', 'approved'))
                ->with('payment')
                ->get()
                ->sum(fn($b) => $b->payment?->amount ?? 0),
        ];

        $availableTickets = Ticket::where('status', Ticket::STATUS_AVAILABLE)
            ->orderBy('departure_date')
            ->take(8)
            ->get();

        $recentBookings = $vendor->bookings()
            ->with(['ticket', 'payment'])
            ->latest()
            ->take(5)
            ->get();

        return view('vendor.dashboard', compact('vendor', 'stats', 'availableTickets', 'recentBookings'));
    }
}
