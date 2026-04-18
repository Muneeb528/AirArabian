<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'account_title',
        'account_number',
        'iban',
        'branch',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Bank color/icon map
    public function bankColor(): string
    {
        return match(strtoupper($this->bank_name)) {
            'HBL'    => '#007A3D',
            'BAFL'   => '#E53E3E',
            'MEEZAN' => '#1A6B3C',
            'FBL'    => '#003DA5',
            'UBL'    => '#005EB8',
            default  => '#6B7280',
        };
    }

    public function bankIcon(): string
    {
        return match(strtoupper($this->bank_name)) {
            'HBL'    => 'fas fa-university',
            'BAFL'   => 'fas fa-landmark',
            'MEEZAN' => 'fas fa-mosque',
            'FBL'    => 'fas fa-piggy-bank',
            'UBL'    => 'fas fa-building',
            default  => 'fas fa-bank',
        };
    }
}
