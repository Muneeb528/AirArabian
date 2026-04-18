<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    const METHOD_JAZZCASH  = 'jazzcash';
    const METHOD_EASYPAISA = 'easypaisa';
    const METHOD_BALANCE   = 'balance';

    const STATUS_PENDING  = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'booking_id',
        'method',
        'amount',
        'proof_image',
        'transaction_id',
        'status',
        'admin_note',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }
}
