<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $query = Vendor::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('company_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $vendors = $query->latest()->paginate(15);
        return view('admin.vendors.index', compact('vendors'));
    }

    public function show(Vendor $vendor)
    {
        $vendor->load('user', 'bookings.ticket');
        return view('admin.vendors.show', compact('vendor'));
    }

    public function approve(Vendor $vendor)
    {
        $vendor->update(['status' => Vendor::STATUS_APPROVED]);
        return back()->with('success', 'Vendor approved. You can now assign login credentials.');
    }

    public function reject(Request $request, Vendor $vendor)
    {
        $request->validate(['reason' => 'nullable|string|max:500']);
        $vendor->update([
            'status'           => Vendor::STATUS_REJECTED,
            'rejection_reason' => $request->reason,
        ]);
        return back()->with('success', 'Vendor application rejected.');
    }

    public function assignCredentials(Request $request, Vendor $vendor)
    {
        $request->validate([
            'username' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($vendor->user_id) {
            // Update existing user credentials
            $vendor->user->update([
                'email'    => $request->username,
                'password' => Hash::make($request->password),
            ]);
        } else {
            // Create new user account for vendor
            $user = User::create([
                'name'     => $vendor->company_name,
                'email'    => $request->username,
                'password' => Hash::make($request->password),
                'role'     => User::ROLE_VENDOR,
            ]);
            $vendor->update(['user_id' => $user->id]);
        }

        return back()->with('success', "Credentials assigned to {$vendor->company_name}. Email: {$request->username}");
    }
}
