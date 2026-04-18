<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorInquiryController extends Controller
{
    public function show()
    {
        return view('vendor-inquiry');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:100',
            'company_name' => 'required|string|max:150',
            'phone'        => 'required|string|max:20',
            'email'        => 'required|email|unique:vendors,email',
            'address'      => 'nullable|string|max:250',
        ]);

        Vendor::create([
            'user_id'      => null,
            'company_name' => $validated['company_name'],
            'phone'        => $validated['phone'],
            'email'        => $validated['email'],
            'address'      => $validated['address'] ?? null,
            'status'       => Vendor::STATUS_PENDING,
        ]);

        return redirect()->route('vendor.inquiry')
            ->with('success', 'Your vendor application has been submitted! Admin will review and contact you shortly.');
    }
}
