<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\Vendor;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_tickets'   => Ticket::count(),
            'available_tickets' => Ticket::where('status', Ticket::STATUS_AVAILABLE)->count(),
            'hold_tickets'    => Ticket::where('status', Ticket::STATUS_HOLD)->count(),
            'booked_tickets'  => Ticket::where('status', Ticket::STATUS_BOOKED)->count(),
            'total_vendors'   => Vendor::count(),
            'pending_vendors' => Vendor::where('status', Vendor::STATUS_PENDING)->count(),
            'approved_vendors'=> Vendor::where('status', Vendor::STATUS_APPROVED)->count(),
            'total_bookings'  => Booking::count(),
            'pending_bookings'=> Booking::where('status', Booking::STATUS_PENDING)->count(),
            'total_payments'  => Payment::count(),
            'pending_payments'=> Payment::where('status', Payment::STATUS_PENDING)->count(),
            'total_revenue'   => Payment::where('status', Payment::STATUS_APPROVED)->sum('amount'),
        ];

        $recentBookings = Booking::with(['vendor', 'ticket'])
            ->latest()
            ->take(5)
            ->get();

        $recentPayments = Payment::with(['booking.vendor'])
            ->where('status', Payment::STATUS_PENDING)
            ->latest()
            ->take(5)
            ->get();

        $pendingVendors = Vendor::where('status', Vendor::STATUS_PENDING)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'recentPayments', 'pendingVendors'));
    }
}
