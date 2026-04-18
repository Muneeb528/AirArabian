<?php

namespace App\Http\Controllers\VendorPortal;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;

class BankAccountController extends Controller
{
    public function index()
    {
        $banks = BankAccount::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('vendor.bank-accounts', compact('banks'));
    }
}
