<?php

namespace App\Http\Controllers\VendorPortal;

use App\Http\Controllers\Controller;
use App\Mail\NewBookingMail;
use App\Models\Booking;
use App\Models\HoldTicket;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $vendor = auth()->user()->vendor;

        $query = $vendor->bookings()->with(['ticket', 'payment']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings  = $query->latest()->paginate(15);
        $statuses  = [
            ''             => 'All',
            'hold'         => 'Hold',
            'partial_sold' => 'Partial Sold',
            'confirmed'    => 'Confirmed',
            'cancelled'    => 'Canceled',
        ];

        return view('vendor.bookings.index', compact('bookings', 'statuses'));
    }

    /**
     * New Booking page — category card selection
     */
    public function newBooking()
    {
        $categories = Booking::CATEGORIES;
        return view('vendor.bookings.new-booking', compact('categories'));
    }

    /**
     * Show booking form after selecting category
     */
    public function create(Request $request)
    {
        $category = $request->get('category', Booking::CATEGORIES[0]);
        $vendor   = auth()->user()->vendor;

        return view('vendor.bookings.create', compact('category', 'vendor'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category'       => 'required|string',
            'pnr'            => 'nullable|string|max:50',
            'group_name'     => 'nullable|string|max:100',
            'customer_name'  => 'required|string|max:100',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:100',
            'adults'         => 'required|integer|min:1',
            'children'       => 'nullable|integer|min:0',
            'travel_date'    => 'required|date',
            'return_date'    => 'nullable|date|after_or_equal:travel_date',
            'total_amount'   => 'required|numeric|min:0',
            'notes'          => 'nullable|string|max:1000',
        ]);

        $vendor = auth()->user()->vendor;

        $booking = Booking::create([
            'vendor_id'       => $vendor->id,
            'ticket_id'       => null,
            'category'        => $validated['category'],
            'pnr'             => $validated['pnr'] ?? null,
            'group_name'      => $validated['group_name'] ?? null,
            'customer_name'   => $validated['customer_name'],
            'customer_phone'  => $validated['customer_phone'],
            'customer_email'  => $validated['customer_email'] ?? null,
            'passenger_count' => ($validated['adults'] ?? 1) + ($validated['children'] ?? 0),
            'adults'          => $validated['adults'],
            'children'        => $validated['children'] ?? 0,
            'travel_date'     => $validated['travel_date'],
            'return_date'     => $validated['return_date'] ?? null,
            'total_amount'    => $validated['total_amount'],
            'status'          => Booking::STATUS_HOLD,
            'notes'           => $validated['notes'] ?? null,
        ]);

        // Send email to vendor + admin
        $adminEmail = config('mail.admin_email', env('ADMIN_EMAIL', 'admin@airarbian.com'));

        try {
            Mail::to($vendor->email ?? $vendor->user->email)->send(new NewBookingMail($booking));
            Mail::to($adminEmail)->send(new NewBookingMail($booking));
        } catch (\Throwable $e) {
            Log::error('Failed to send new booking email: ' . $e->getMessage());
        }

        return redirect()->route('vendor.bookings.index')
            ->with('success', "Booking #{$booking->invoice_number} created! Payment is due within 4 hours.");
    }

    public function show(Booking $booking)
    {
        $vendor = auth()->user()->vendor;

        if ($booking->vendor_id !== $vendor->id) {
            abort(403);
        }

        $booking->load(['ticket', 'payment']);
        return view('vendor.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        $vendor = auth()->user()->vendor;
        if ($booking->vendor_id !== $vendor->id) {
            abort(403);
        }
        $booking->update(['status' => Booking::STATUS_CANCELLED]);
        return redirect()->route('vendor.bookings.index')->with('success', 'Booking cancelled.');
        public function newBooking()
    {
        $categories = [
            ['name' => 'UMRAH PACKAGE',    'slug' => 'umrah-package', 'subtitle' => 'COMPLETE UMRAH PACKAGE',    'image' => 'https://images.unsplash.com/photo-1591604466107-ec97de577aff?w=400'],
            ['name' => 'Umrah Tickets',    'slug' => 'umrah-tickets', 'subtitle' => 'Kingdom of Saudi Arabia',   'image' => 'https://images.unsplash.com/photo-1564769625905-50e93615e769?w=400'],
            ['name' => 'KSA Oneway Groups','slug' => 'ksa',           'subtitle' => 'Kingdom of Saudi Arabia',   'image' => 'https://images.unsplash.com/photo-1578895101408-1a36b834405b?w=400'],
            ['name' => 'UAE Flights',      'slug' => 'uae',           'subtitle' => 'United Arab Emirates',      'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=400'],
            ['name' => 'Oman Tours',       'slug' => 'oman',          'subtitle' => 'Sultanate of Oman',         'image' => 'https://images.unsplash.com/photo-1578895101408-1a36b834405b?w=400'],
            ['name' => 'UK / Europe',      'slug' => 'uk',            'subtitle' => 'United Kingdom & Europe',   'image' => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?w=400'],
        ];
        return view('vendor.new-booking', compact('categories'));
    }

    public function bookingGroups(Request $request, $category)
    {
        $groups = \App\Models\BookingGroup::where('category', $category)
            ->with(['flights' => function($q) use ($request) {
                $q->where('status', 'active')
                  ->where('flight_date', '>=', now()->toDateString());

                if ($request->date) {
                    $q->whereDate('flight_date', \Carbon\Carbon::createFromFormat('d-m-Y', $request->date));
                }
                if ($request->keyword) {
                    $q->where(function($sq) use ($request) {
                        $sq->where('flight_number', 'like', '%'.$request->keyword.'%')
                           ->orWhere('destination', 'like', '%'.$request->keyword.'%');
                    });
                }
                $q->orderBy('flight_date');
            }])
            ->get();

        $sectors = $groups->map(fn($g) => $g->sector_origin.'-'.$g->sector_destination)->unique();

        return view('vendor.booking-groups', compact('groups', 'category', 'sectors'));
    }

    public function bookNow($flightId)
    {
        $flight = \App\Models\GroupFlight::with('bookingGroup')->findOrFail($flightId);
        return view('vendor.book-now', compact('flight'));
    }

    public function storeBooking(Request $request, $flightId)
    {
        $request->validate([
            'passenger_name' => 'required|string|max:255',
            'passport_no'    => 'required|string|max:50',
            'contact_mobile' => 'required|string|max:20',
            'contact_email'  => 'required|email',
            'adults'         => 'required|integer|min:1',
            'children'       => 'nullable|integer|min:0',
            'infants'        => 'nullable|integer|min:0',
        ]);

        $flight = \App\Models\GroupFlight::with('bookingGroup')->findOrFail($flightId);
        $now    = \Carbon\Carbon::now();
        $vendor = auth()->user()->vendor;

        $booking = Booking::create([
            'invoice_no'      => 'INV-' . strtoupper(uniqid()),
            'vendor_id'       => $vendor->id,
            'group_flight_id' => $flightId,
            'passenger_name'  => $request->passenger_name,
            'passport_no'     => $request->passport_no,
            'contact_mobile'  => $request->contact_mobile,
            'contact_email'   => $request->contact_email,
            'adults'          => $request->adults,
            'children'        => $request->children ?? 0,
            'infants'         => $request->infants  ?? 0,
            'price'           => $flight->price_pkr,
            'payment_status'  => 'hold',
            'booking_status'  => 'active',
            'booking_type'    => 'ticket',
            'reserved_time'   => $now,
            'cancel_deadline' => $now->copy()->addHours(4),
        ]);

        // Emails
        $adminEmail  = config('mail.admin_email', env('ADMIN_EMAIL', 'admin@gmail.com'));
        $vendorEmail = $vendor->email;

        try {
            Mail::to($vendorEmail)->send(new NewBookingMail($booking, $flight));
            Mail::to($adminEmail)->send(new NewBookingMail($booking, $flight));
        } catch (\Exception $e) {
            Log::error('Email failed: ' . $e->getMessage());
        }

        return redirect()->route('vendor.my-tickets')
            ->with('success', '✅ Booking created! Payment karo 4 ghanton mein warna cancel ho jayegi.');
    }

    public function myUmrah(Request $request)
    {
        $vendor   = auth()->user()->vendor;
        $bookings = Booking::where('vendor_id', $vendor->id)
            ->where('booking_type', 'umrah')
            ->latest()
            ->paginate(15);

        return view('vendor.my-umrah', compact('bookings'));
    }
    }
}
