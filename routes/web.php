<?php

use App\Livewire\Admin;
use App\Livewire\Contact\ContactForm;
use App\Livewire\Home;
use App\Livewire\Properties;
use App\Livewire\Promoter;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', Home::class)->name('home');
Route::get('/properties', Properties\Index::class)->name('properties.index');
Route::get('/properties/{id}', Properties\Show::class)->name('properties.show');
Route::get('/contact', ContactForm::class)->name('contact');

// Authentication routes (using modals now, but need named routes for middleware)
Route::get('/login', function() {
    return redirect('/')->with('openLoginModal', true);
})->name('login');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Promoter registration (public)
Route::get('/become-promoter', Promoter\Registration::class)->name('promoter.register');

// Promoter pending page
Route::middleware(['auth', 'role:promoter'])->group(function () {
    Route::view('/promoter/pending', 'promoter.pending')->name('promoter.pending');
});

// Promoter routes (authenticated + verified)
Route::middleware(['auth', 'role:promoter', 'verified.promoter'])->prefix('promoter')->group(function () {
    Route::get('/dashboard', Promoter\Dashboard::class)->name('promoter.dashboard');
    Route::get('/properties', Promoter\Properties\PropertyManager::class)->name('promoter.properties');
    Route::get('/properties/create', [Promoter\Properties\PropertyForm::class, '__invoke'])->name('promoter.properties.create');
    Route::get('/properties/{id}/edit', Promoter\Properties\PropertyForm::class)->name('promoter.properties.edit');
    Route::get('/bookings', Promoter\Bookings\BookingManagement::class)->name('promoter.bookings');
    Route::get('/renewals', Promoter\Renewals\RenewalManagement::class)->name('promoter.renewals');
    Route::get('/maintenance', Promoter\Maintenance\MaintenanceManagement::class)->name('promoter.maintenance');
    Route::get('/messages', Promoter\Messages\MessageInbox::class)->name('promoter.messages');
});

// Client routes (authenticated)
Route::middleware(['auth', 'role:client'])->prefix('my')->group(function () {
    Route::get('/dashboard', \App\Livewire\Client\Dashboard::class)->name('client.dashboard');
    Route::get('/bookings', \App\Livewire\Client\Bookings\BookingList::class)->name('client.bookings');
    Route::get('/maintenance', \App\Livewire\Client\Maintenance\MaintenanceRequests::class)->name('client.maintenance.index');
    Route::get('/maintenance/create', \App\Livewire\Client\Maintenance\MaintenanceRequests::class)->name('client.maintenance.create');
    Route::get('/messages', \App\Livewire\Client\Messages\MessageCenter::class)->name('client.messages');
    Route::view('/profile', 'client.profile')->name('client.profile');
    // TODO: Create these Livewire components
    // Route::get('/bookings/{id}', \App\Livewire\Client\Bookings\BookingDetails::class)->name('client.bookings.show');
    // Route::get('/payments', \App\Livewire\Client\Payments\PaymentHistory::class)->name('client.payments');
    // Route::get('/renewals', \App\Livewire\Client\Renewals\RenewalRequests::class)->name('client.renewals');
});

// Booking routes (authenticated)
Route::middleware(['auth'])->prefix('booking')->group(function () {
    Route::get('/{propertyId}', \App\Livewire\Booking\BookingForm::class)->name('booking.create');
    Route::get('/{bookingId}/payment', \App\Livewire\Payment\PaymentForm::class)->name('payment.show');
});

// Admin Authentication routes (guest)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [\App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('logout');
});

// Admin routes (authenticated + admin role)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('/properties', Admin\Properties\PropertyList::class)->name('admin.properties');
    Route::get('/bookings', Admin\Bookings\BookingList::class)->name('admin.bookings');
    Route::get('/promoters', Admin\Promoters\PromoterList::class)->name('admin.promoters');
    Route::get('/contacts', Admin\Contacts\ContactList::class)->name('admin.contacts');
    Route::get('/payments', Admin\Payments\PaymentList::class)->name('admin.payments');
    Route::get('/renewals', Admin\Renewals\RenewalList::class)->name('admin.renewals');
    Route::get('/maintenance', Admin\Maintenance\MaintenanceList::class)->name('admin.maintenance');
    
    // Page d'exemples UI (pour développement)
    Route::get('/exemples/ui-elements', [\App\Http\Controllers\Admin\ExemplesController::class, 'uiElements'])->name('admin.exemples.ui-elements');
});
