<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfVendorAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isVendor()) {
            return redirect()->route('vendor.dashboard');
        }
        return $next($request);
    }
}
