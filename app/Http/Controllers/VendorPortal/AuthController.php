<?php

namespace App\Http\Controllers\VendorPortal;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->isVendor()) {
            return redirect()->route('vendor.dashboard');
        }
        return view('vendor.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            if ($user->isVendor()) {
                $vendor = $user->vendor;
                if ($vendor && $vendor->isApproved()) {
                    $request->session()->regenerate();
                    return redirect()->intended(route('vendor.dashboard'));
                }
                Auth::logout();
                return back()->withErrors(['email' => 'Your account is pending admin approval.'])->onlyInput('email');
            }
            Auth::logout();
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check() && Auth::user()->isVendor()) {
            return redirect()->route('vendor.dashboard');
        }
        return view('vendor.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:100',
            'company_name' => 'required|string|max:150',
            'email'        => 'required|email|unique:users,email',
            'phone'        => 'required|string|max:20',
            'address'      => 'nullable|string|max:255',
            'password'     => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'vendor',
        ]);

        Vendor::create([
            'user_id'      => $user->id,
            'company_name' => $request->company_name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'address'      => $request->address,
            'status'       => Vendor::STATUS_PENDING,
        ]);

        return redirect()->route('vendor.login')
            ->with('success', 'Registration successful! Your account is pending admin approval. You will be notified once approved.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('vendor.login')->with('success', 'Logged out successfully.');
    }
}
