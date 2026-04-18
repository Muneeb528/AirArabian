<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $validCategories = ['UAE', 'KSA', 'Umrah', 'Tour'];
    $ticketsByCategory = [];
    $category = request('category', '');
    
    foreach ($validCategories as $cat) {
        $ticketsByCategory[$cat] = \App\Models\Ticket::where('category', $cat)
            ->where('status', 'available')
            ->count();
    }
    
    $tickets = \App\Models\Ticket::where('status', 'available')->get();
    
    return view('home', compact('validCategories', 'ticketsByCategory', 'category', 'tickets'));
})->name('home');

Route::get('/vendor-inquiry', function () {
    return view('vendor-inquiry');
})->name('vendor.inquiry');

// Vendor Routes
Route::get('/vendor/login', function () {
    return view('vendor.login');
})->name('vendor.login');

Route::get('/vendor/dashboard', function () {
    return view('vendor.dashboard');
})->name('vendor.dashboard');

// Admin Routes
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');