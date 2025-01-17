<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FestivalAdminController;
use App\Http\Controllers\FestivalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicReizenController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Welcome Page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/reizen/guest', [PublicReizenController::class, 'index'])->name('reizen.guest');




// Admin routes
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    // Klanten overzicht
    Route::get('/customers', [CustomerController::class, 'index'])->name('admin.customers.index');

    // Klant bewerken
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('admin.customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('admin.customers.update');
    Route::get('/customers/{customer}/history', [CustomerController::class, 'showHistory'])->name('admin.customers.history');


    // Klant toevoegen
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('admin.customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('admin.customers.store');

    // Klant verwijderen
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy');

    // Klantpunten beheren
    route::get('/customers/points/list', [CustomerController::class, 'showPoints'])->name('admin.points.index');
    Route::get('/customers/{customer}/points', [CustomerController::class, 'editPoints'])->name('admin.points.edit');
    Route::put('/customers/{customer}/points', [CustomerController::class, 'updatePoints'])->name('admin.points.update');

    // Reizen Overzicht
    Route::get('/reizen', [FestivalAdminController::class, 'index'])->name('admin.reizen.index');
    Route::get('/reizen/create', [FestivalAdminController::class, 'create'])->name('admin.reizen.create');
    Route::post('/reizen', [FestivalAdminController::class, 'store'])->name('admin.reizen.store');
    Route::get('/admin/reizen/{festival}/edit', [FestivalAdminController::class, 'edit'])->name('admin.reizen.edit');
    Route::put('/admin/reizen/{festival}', [FestivalAdminController::class, 'update'])->name('admin.reizen.update');
    Route::delete('/admin/reizen/{festival}', [FestivalAdminController::class, 'destroy'])->name('admin.reizen.destroy');

    // maak bus aan
    Route::get('/buses/create', [FestivalAdminController::class, 'createBus'])->name('admin.buses.create');
    Route::post('/admin/buses', [FestivalAdminController::class, 'storeBus'])->name('admin.buses.store');
});


// Profile Routes for authenticated users
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/d', [DashboardController::class, 'admin'])->name('admin.dashboard');

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Festival routes
    Route::get('/reizen', [FestivalController::class, 'index'])->name('reizen.index'); // Festival lijst
    Route::get('/reizen/{festival}', [FestivalController::class, 'show'])->name('reizen.show'); // Festival details


    // Bookings for bus planning
    Route::post('/reizen/{busPlanning}/book', [BookingController::class, 'store'])->name('reizen.book'); // Boeking opslaan
    Route::post('/reizen/{busPlanning}/redeem', [BookingController::class, 'redeemPoints'])->name('reizen.redeem');


    // Booking manage routes
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
