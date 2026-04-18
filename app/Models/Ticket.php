<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    const CATEGORY_UAE   = 'UAE';
    const CATEGORY_KSA   = 'KSA';
    const CATEGORY_UMRAH = 'Umrah';
    const CATEGORY_TOUR  = 'Tour';

    const STATUS_AVAILABLE  = 'available';
    const STATUS_BOOKED     = 'booked';
    const STATUS_HOLD       = 'hold';
    const STATUS_CANCELLED  = 'cancelled';

    protected $fillable = [
        'category',
        'title',
        'description',
        'airline',
        'origin',
        'destination',
        'price',
        'seats_available',
        'departure_date',
        'return_date',
        'status',
        'image',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'return_date'    => 'date',
        'price'          => 'decimal:2',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function holdTicket()
    {
        return $this->hasOne(HoldTicket::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_AVAILABLE && $this->seats_available > 0;
    }

    public function isOnHold(): bool
    {
        return $this->status === self::STATUS_HOLD;
    }

    public static function categories(): array
    {
        return [
            self::CATEGORY_UAE,
            self::CATEGORY_KSA,
            self::CATEGORY_UMRAH,
            self::CATEGORY_TOUR,
        ];
    }

    public function statusBadgeClass(): string
    {
        return match($this->status) {
            self::STATUS_AVAILABLE  => 'badge-available',
            self::STATUS_BOOKED     => 'badge-booked',
            self::STATUS_HOLD       => 'badge-hold',
            self::STATUS_CANCELLED  => 'badge-cancelled',
            default                 => 'badge-secondary',
        };
    }
}
