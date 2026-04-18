<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['booking.vendor', 'booking.ticket']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        $payments = $query->latest()->paginate(15);
        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['booking.vendor.user', 'booking.ticket']);
        return view('admin.payments.show', compact('payment'));
    }

    public function approve(Request $request, Payment $payment)
    {
        $payment->update(['status' => Payment::STATUS_APPROVED]);

        // Confirm the booking and mark ticket as booked
        $booking = $payment->booking;
        $booking->update(['status' => Booking::STATUS_CONFIRMED]);

        $ticket = $booking->ticket;
        $ticket->update(['status' => Ticket::STATUS_BOOKED]);
        $ticket->holdTicket()->delete();

        return back()->with('success', 'Payment approved and booking confirmed.');
    }

    public function reject(Request $request, Payment $payment)
    {
        $request->validate(['admin_note' => 'nullable|string|max:500']);

        $payment->update([
            'status'     => Payment::STATUS_REJECTED,
            'admin_note' => $request->admin_note,
        ]);

        // Release the ticket back to available
        $ticket = $payment->booking->ticket;
        $ticket->update(['status' => Ticket::STATUS_AVAILABLE]);
        $ticket->holdTicket()->delete();

        return back()->with('success', 'Payment rejected and ticket released.');
    }
}
