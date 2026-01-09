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
    // Properties routes
    Route::get('/properties', Admin\Properties\PropertyList::class)->name('admin.properties');
    Route::get('/properties/{id}', Admin\Properties\PropertyDetail::class)->name('admin.properties.show');
    Route::get('/properties/{id}/edit', Admin\Properties\PropertyForm::class)->name('admin.properties.edit');
    Route::get('/properties/create', Admin\Properties\PropertyForm::class)->name('admin.properties.create');
    
    // Bookings routes
    Route::get('/bookings', Admin\Bookings\BookingList::class)->name('admin.bookings');
    Route::get('/bookings/{id}', Admin\Bookings\BookingDetail::class)->name('admin.bookings.show');
    Route::get('/bookings/{id}/edit', Admin\Bookings\BookingForm::class)->name('admin.bookings.edit');
    Route::get('/bookings/create', Admin\Bookings\BookingForm::class)->name('admin.bookings.create');
    
    // Promoters routes
    Route::get('/promoters', Admin\Promoters\PromoterList::class)->name('admin.promoters');
    Route::get('/promoters/{id}', Admin\Promoters\PromoterDetail::class)->name('admin.promoters.show');
    Route::get('/promoters/{id}/edit', Admin\Promoters\PromoterForm::class)->name('admin.promoters.edit');
    Route::get('/promoters/create', Admin\Promoters\PromoterForm::class)->name('admin.promoters.create');
    
    // Payments routes
    Route::get('/payments', Admin\Payments\PaymentList::class)->name('admin.payments');
    Route::get('/payments/{id}', Admin\Payments\PaymentDetail::class)->name('admin.payments.show');
    
    // Validations routes
    Route::get('/validations', Admin\Validations\ValidationList::class)->name('admin.validations.index');
    Route::get('/validations/{id}', Admin\Validations\ValidationDetail::class)->name('admin.validations.show');
    Route::get('/validations/history', Admin\Validations\ValidationHistory::class)->name('admin.validations.history');
    
    // Commissions routes
    Route::get('/commissions', Admin\Commissions\CommissionList::class)->name('admin.commissions.index');
    Route::get('/commissions/{id}', Admin\Commissions\CommissionDetail::class)->name('admin.commissions.show');
    
    // Clients routes
    Route::get('/clients', Admin\Clients\ClientList::class)->name('admin.clients.index');
    Route::get('/clients/{id}', Admin\Clients\ClientDetail::class)->name('admin.clients.show');
    
    // Notifications routes
    Route::get('/notifications', Admin\Notifications\NotificationList::class)->name('admin.notifications.index');
    Route::get('/notifications/create', Admin\Notifications\NotificationCreate::class)->name('admin.notifications.create');
    Route::post('/notifications/{notification}/read', function ($notification) {
        $notification = \App\Models\Notification::findOrFail($notification);
        if ($notification->utilisateur_id === auth()->id()) {
            $notification->marquerCommeLue();
        }
        return redirect()->back();
    })->name('admin.notifications.read');
    
    Route::post('/notifications/read-all', function () {
        \App\Models\Notification::where('utilisateur_id', auth()->id())
            ->where('est_lue', false)
            ->update([
                'est_lue' => true,
                'date_lecture' => now(),
            ]);
        return redirect()->back();
    })->name('admin.notifications.read-all');
    
    // Settings routes
    Route::get('/settings', Admin\Settings\SettingsIndex::class)->name('admin.settings');
    
    // Page d'exemples UI (pour développement)
    Route::get('/exemples/ui-elements', [\App\Http\Controllers\Admin\ExemplesController::class, 'uiElements'])->name('admin.exemples.ui-elements');
});
