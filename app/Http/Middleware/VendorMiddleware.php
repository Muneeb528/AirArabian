<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VendorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isVendor()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            return redirect()->route('vendor.login')->with('error', 'Please login as vendor to continue.');
        }

        // Check vendor is approved
        $vendor = auth()->user()->vendor;
        if (!$vendor || !$vendor->isApproved()) {
            auth()->logout();
            return redirect()->route('vendor.login')->with('error', 'Your vendor account is not yet approved.');
        }

        return $next($request);
    }
}
