<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $validCategories = ['UAE', 'KSA', 'Umrah', 'Tour'];
    $ticketsByCategory = [];
    $category = request('category', '');

    foreach ($validCategories as $cat) {
        $ticketsByCategory[$cat] = \App\Models\Ticket::where('category', $cat)
            ->where('status', 'available')
            ->get();
    }

    $tickets = \App\Models\Ticket::where('status', 'available')->get();

    return view('home', compact('validCategories', 'ticketsByCategory', 'category', 'tickets'));
})->name('home');

Route::get('/vendor-inquiry', function () {
    return view('vendor-inquiry');
})->name('vendor.inquiry');

// ─── Admin Auth ──────────────────────────────────────────────────────────────
Route::get('/admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

// ─── Vendor Auth ─────────────────────────────────────────────────────────────
Route::get('/vendor/login', [\App\Http\Controllers\VendorPortal\AuthController::class, 'showLogin'])->name('vendor.login');
Route::post('/vendor/login', [\App\Http\Controllers\VendorPortal\AuthController::class, 'login'])->name('vendor.login.post');
Route::get('/vendor/register', [\App\Http\Controllers\VendorPortal\AuthController::class, 'showRegister'])->name('vendor.register');
Route::post('/vendor/register', [\App\Http\Controllers\VendorPortal\AuthController::class, 'register'])->name('vendor.register.post');
Route::post('/vendor/logout', [\App\Http\Controllers\VendorPortal\AuthController::class, 'logout'])->name('vendor.logout');
// ---- Vendor Protected Routes ----
Route::middleware(['auth:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard',                    [\App\Http\Controllers\VendorPortal\BookingController::class, 'dashboard'])->name('dashboard');
    Route::get('/new-booking',                  [\App\Http\Controllers\VendorPortal\BookingController::class, 'newBooking'])->name('new-booking');
    Route::get('/booking-groups/{category}',    [\App\Http\Controllers\VendorPortal\BookingController::class, 'bookingGroups'])->name('booking-groups');
    Route::get('/book-now/{flightId}',          [\App\Http\Controllers\VendorPortal\BookingController::class, 'bookNow'])->name('book-now');
    Route::post('/book-now/{flightId}',         [\App\Http\Controllers\VendorPortal\BookingController::class, 'storeBooking'])->name('store-booking');
    Route::get('/my-tickets',                   [\App\Http\Controllers\VendorPortal\BookingController::class, 'index'])->name('my-tickets');
    Route::get('/my-umrah',                     [\App\Http\Controllers\VendorPortal\BookingController::class, 'myUmrah'])->name('my-umrah');
    Route::get('/bank-accounts',                [\App\Http\Controllers\VendorPortal\BankAccountController::class, 'index'])->name('bank-accounts');
    Route::get('/settings',                     [\App\Http\Controllers\VendorPortal\SettingsController::class, 'index'])->name('settings');
    Route::post('/settings',                    [\App\Http\Controllers\VendorPortal\SettingsController::class, 'update'])->name('settings.update');
    Route::get('/ledger',                       [\App\Http\Controllers\VendorPortal\BookingController::class, 'ledger'])->name('ledger');
    Route::get('/feedback',                     [\App\Http\Controllers\VendorPortal\BookingController::class, 'feedback'])->name('feedback');
    Route::post('/feedback',                    [\App\Http\Controllers\VendorPortal\BookingController::class, 'storeFeedback'])->name('feedback.store');
});

// ─── Admin Portal ─────────────────────────────────────────────────────────────
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/tickets', \App\Http\Controllers\Admin\TicketController::class);
    Route::resource('/vendors', \App\Http\Controllers\Admin\VendorController::class);
    Route::resource('/bookings', \App\Http\Controllers\Admin\BookingController::class);
    Route::resource('/payments', \App\Http\Controllers\Admin\PaymentController::class);
    Route::post('/tickets/{ticket}/toggle-status', [\App\Http\Controllers\Admin\TicketController::class, 'toggleStatus'])->name('tickets.toggle-status');
    Route::resource('/bank-accounts', \App\Http\Controllers\Admin\BankAccountController::class)->except(['create','show','edit']);
});

// ─── Vendor Portal ────────────────────────────────────────────────────────────
Route::middleware(['vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\VendorPortal\DashboardController::class, 'index'])->name('dashboard');

    // New Booking (category selection page)
    Route::get('/bookings/new', [\App\Http\Controllers\VendorPortal\BookingController::class, 'newBooking'])->name('bookings.new');

    // Booking form (after selecting category)
    Route::get('/bookings/create', [\App\Http\Controllers\VendorPortal\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [\App\Http\Controllers\VendorPortal\BookingController::class, 'store'])->name('bookings.store');

    // My Ticket Bookings list
    Route::get('/bookings', [\App\Http\Controllers\VendorPortal\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [\App\Http\Controllers\VendorPortal\BookingController::class, 'show'])->name('bookings.show');
    Route::delete('/bookings/{booking}', [\App\Http\Controllers\VendorPortal\BookingController::class, 'destroy'])->name('bookings.destroy');

    // Bank Accounts
    Route::get('/bank-accounts', [\App\Http\Controllers\VendorPortal\BankAccountController::class, 'index'])->name('bank-accounts');

    // Settings
    Route::get('/settings', [\App\Http\Controllers\VendorPortal\SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [\App\Http\Controllers\VendorPortal\SettingsController::class, 'update'])->name('settings.update');
});

// Vendor Routes
Route::prefix('vendor')->middleware(['auth:vendor'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('vendor.dashboard');
    Route::get('/new-booking', [BookingController::class, 'newBooking'])->name('vendor.new-booking');
    Route::get('/booking-groups/{category}', [BookingController::class, 'bookingGroups'])->name('vendor.booking-groups');
    Route::get('/book-now/{flightId}', [BookingController::class, 'bookNow'])->name('vendor.book-now');
    Route::post('/book-now/{flightId}', [BookingController::class, 'storeBooking'])->name('vendor.store-booking');
    Route::get('/my-tickets', [BookingController::class, 'myTickets'])->name('vendor.my-tickets');
    Route::get('/my-umrah', [BookingController::class, 'myUmrah'])->name('vendor.my-umrah');
    Route::get('/bank-accounts', [BankAccountController::class, 'index'])->name('vendor.bank-accounts');
    Route::get('/ledger', [LedgerController::class, 'index'])->name('vendor.ledger');
    Route::get('/settings', [SettingsController::class, 'index'])->name('vendor.settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('vendor.settings.update');
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('vendor.feedback');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('vendor.feedback.store');
});