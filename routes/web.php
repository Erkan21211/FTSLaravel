<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FestivalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

// Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// Profile Routes for authenticated users
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Festival routes
    Route::get('/reizen', [FestivalController::class, 'index'])->name('reizen.index'); // Festival lijst
    Route::get('/reizen/{festival}', [FestivalController::class, 'show'])->name('reizen.show'); // Festival details


    // Bookings for bus planning
    Route::post('/reizen/{busPlanning}/book', [BookingController::class, 'store'])->name('reizen.book'); // Correcte route

    // Booking management
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index'); // Geschiedenis
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store'); // Boeking opslaan
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show'); // Details busrit pagina
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel'); // Annuleren
});

// Registration routes
Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrationController::class, 'register'])->name('register.submit');

// Include Default Authentication Routes
require __DIR__ . '/auth.php';
