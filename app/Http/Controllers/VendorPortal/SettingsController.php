<?php

namespace App\Http\Controllers\VendorPortal;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::allAsArray();
        return view('vendor.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'agency_name'  => 'required|string|max:150',
            'city'         => 'required|string|max:100',
            'email'        => 'required|email',
            'mobile'       => 'required|string|max:20',
            'logo'         => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        Setting::set('agency_name', $request->agency_name);
        Setting::set('city', $request->city);
        Setting::set('email', $request->email);
        Setting::set('mobile', $request->mobile);

        if ($request->hasFile('logo')) {
            // Delete old logo
            $oldLogo = Setting::get('logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
            $logoPath = $request->file('logo')->store('settings', 'public');
            Setting::set('logo', $logoPath);
        }

        return back()->with('success', 'Settings saved successfully!');
    }
}
