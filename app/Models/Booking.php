<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    const STATUS_HOLD         = 'hold';
    const STATUS_PARTIAL_SOLD = 'partial_sold';
    const STATUS_CONFIRMED    = 'confirmed';
    const STATUS_CANCELLED    = 'cancelled';
    const STATUS_PENDING      = 'pending';  // legacy

    const CATEGORIES = [
        'Umrah Package',
        'Umrah Tickets',
        'KSA Oneway Groups',
        'Dubai',
        'Oman',
        'UK',
    ];

    protected $fillable = [
        'vendor_id',
        'ticket_id',
        'invoice_number',
        'pnr',
        'group_name',
        'category',
        'customer_name',
        'customer_phone',
        'customer_email',
        'passenger_count',
        'adults',
        'children',
        'travel_date',
        'return_date',
        'total_amount',
        'status',
        'notes',
        'payment_deadline',
        'auto_cancel_notified',
    ];

    protected $casts = [
        'total_amount'          => 'decimal:2',
        'travel_date'           => 'date',
        'return_date'           => 'date',
        'payment_deadline'      => 'datetime',
        'auto_cancel_notified'  => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            // Auto-generate invoice number
            if (empty($booking->invoice_number)) {
                $booking->invoice_number = 'INV-' . strtoupper(uniqid());
            }
            // Set 4-hour payment deadline
            if (empty($booking->payment_deadline)) {
                $booking->payment_deadline = now()->addHours(4);
            }
        });
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isHold(): bool
    {
        return $this->status === self::STATUS_HOLD;
    }

    public function isConfirmed(): bool
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function isPaymentOverdue(): bool
    {
        return $this->payment_deadline && now()->isAfter($this->payment_deadline)
            && in_array($this->status, [self::STATUS_HOLD, self::STATUS_PENDING]);
    }

    public function statusBadgeClass(): string
    {
        return match($this->status) {
            self::STATUS_HOLD         => 'badge-hold',
            self::STATUS_PARTIAL_SOLD => 'badge-partial',
            self::STATUS_CONFIRMED    => 'badge-confirmed',
            self::STATUS_CANCELLED    => 'badge-cancelled',
            default                   => 'badge-pending',
        };
    }

    public function statusLabel(): string
    {
        return match($this->status) {
            self::STATUS_HOLD         => 'Hold',
            self::STATUS_PARTIAL_SOLD => 'Partial Sold',
            self::STATUS_CONFIRMED    => 'Confirmed',
            self::STATUS_CANCELLED    => 'Canceled',
            default                   => ucfirst($this->status),
        };
    }
}
