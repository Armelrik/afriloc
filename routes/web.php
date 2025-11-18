<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', App\Livewire\Home::class)->name('home');
Route::get('/properties', App\Livewire\Properties\Index::class)->name('properties.index');
Route::get('/properties/{id}', App\Livewire\Properties\Show::class)->name('properties.show');
Route::get('/contact', App\Livewire\Contact\ContactForm::class)->name('contact');

// Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('/properties', App\Livewire\Admin\Properties\PropertyList::class)->name('admin.properties');
    Route::get('/bookings', App\Livewire\Admin\Bookings\BookingList::class)->name('admin.bookings');
    Route::get('/contacts', App\Livewire\Admin\Contacts\ContactList::class)->name('admin.contacts');
});
