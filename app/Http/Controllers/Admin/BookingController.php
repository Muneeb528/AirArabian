<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['vendor', 'ticket']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_phone', 'like', '%' . $request->search . '%');
            });
        }

        $bookings = $query->latest()->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['vendor.user', 'ticket', 'payment']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        $booking->update(['status' => Booking::STATUS_CANCELLED]);

        // Release ticket if on hold
        $ticket = $booking->ticket;
        if ($ticket->status === Ticket::STATUS_HOLD || $ticket->status === Ticket::STATUS_BOOKED) {
            $ticket->update(['status' => Ticket::STATUS_AVAILABLE]);
            $ticket->holdTicket()->delete();
        }

        return back()->with('success', 'Booking cancelled and ticket released.');
    }
}
