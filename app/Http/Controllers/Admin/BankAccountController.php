<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
        $banks = BankAccount::orderBy('sort_order')->get();
        return view('admin.bank-accounts.index', compact('banks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name'      => 'required|string|max:50',
            'account_title'  => 'required|string|max:150',
            'account_number' => 'required|string|max:50',
            'iban'           => 'nullable|string|max:30',
            'branch'         => 'nullable|string|max:150',
            'sort_order'     => 'nullable|integer',
        ]);

        BankAccount::create($request->only([
            'bank_name','account_title','account_number','iban','branch','sort_order',
        ]) + ['is_active' => true]);

        return back()->with('success', 'Bank account added!');
    }

    public function update(Request $request, BankAccount $bankAccount)
    {
        $request->validate([
            'bank_name'      => 'required|string|max:50',
            'account_title'  => 'required|string|max:150',
            'account_number' => 'required|string|max:50',
            'iban'           => 'nullable|string|max:30',
            'branch'         => 'nullable|string|max:150',
            'is_active'      => 'nullable|boolean',
            'sort_order'     => 'nullable|integer',
        ]);

        $bankAccount->update($request->only([
            'bank_name','account_title','account_number','iban','branch','sort_order',
        ]) + ['is_active' => $request->boolean('is_active')]);

        return back()->with('success', 'Bank account updated!');
    }

    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();
        return back()->with('success', 'Bank account deleted.');
    }
}
