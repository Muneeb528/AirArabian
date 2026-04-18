<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HoldTicket extends Model
{
    use HasFactory;

    const HOLD_DURATION_HOURS = 4;

    protected $fillable = [
        'ticket_id',
        'vendor_id',
        'held_at',
        'release_at',
    ];

    protected $casts = [
        'held_at'    => 'datetime',
        'release_at' => 'datetime',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function isExpired(): bool
    {
        return Carbon::now()->isAfter($this->release_at);
    }

    public function remainingMinutes(): int
    {
        return max(0, Carbon::now()->diffInMinutes($this->release_at, false));
    }

    public static function holdTicket(int $ticketId, int $vendorId): self
    {
        $now = Carbon::now();
        return self::create([
            'ticket_id'  => $ticketId,
            'vendor_id'  => $vendorId,
            'held_at'    => $now,
            'release_at' => $now->copy()->addHours(self::HOLD_DURATION_HOURS),
        ]);
    }
}
