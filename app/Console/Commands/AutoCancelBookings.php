<?php

namespace App\Console\Commands;

use App\Mail\BookingAutoCancelledMail;
use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AutoCancelBookings extends Command
{
    protected $signature = 'bookings:auto-cancel';
    protected $description = 'Auto-cancel bookings where payment was not received within 4 hours';

    public function handle(): int
    {
        $overdueBookings = Booking::whereIn('status', [Booking::STATUS_HOLD, Booking::STATUS_PENDING])
            ->where('payment_deadline', '<=', now())
            ->where('auto_cancel_notified', false)
            ->with(['vendor.user'])
            ->get();

        $count = 0;

        foreach ($overdueBookings as $booking) {
            $booking->update([
                'status'                => Booking::STATUS_CANCELLED,
                'auto_cancel_notified'  => true,
            ]);

            // Send email to vendor
            $vendorEmail = $booking->vendor?->email ?? $booking->vendor?->user?->email;
            if ($vendorEmail) {
                try {
                    Mail::to($vendorEmail)->send(new BookingAutoCancelledMail($booking));
                } catch (\Throwable $e) {
                    Log::error('Failed to send auto-cancel email to vendor: ' . $e->getMessage());
                }
            }

            $count++;
            $this->line("  Cancelled booking #{$booking->invoice_number}");
        }

        $this->info("Auto-cancelled {$count} overdue bookings.");

        return Command::SUCCESS;
    }
}
