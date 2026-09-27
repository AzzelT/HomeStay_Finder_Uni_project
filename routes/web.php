<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingController;


// ─── Public Routes ────────────────────────────────────────────────────────────

Route::get('/', [HotelController::class, 'home'])->name('home');

Route::get('/hotels', [HotelController::class, 'search'])->name('hotels.index');

Route::get('/hotels/{id}', [HotelController::class, 'show'])->name('hotels.show');

Route::get('/about', [ContactController::class, 'about'])->name('about');

Route::get('/contact', [ContactController::class, 'contact'])->name('contact');


// ─── Authentication Routes ───────────────────────────────────────────────────

Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


// ─── Profile Routes ──────────────────────────────────────────────────────────

Route::middleware('auth')->prefix('profile')->group(function () {

    Route::get('/', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::put('/update', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::put('/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');

    Route::get('/reviews', [ProfileController::class, 'reviews'])
        ->name('profile.reviews');
});


// ─── Review Routes ───────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {

    Route::post('/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store');

    Route::get('/my-reviews', [ReviewController::class, 'myReviews'])
        ->name('reviews.my');

    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])
        ->name('reviews.destroy');
});


// ─── Admin Routes ────────────────────────────────────────────────────────────

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Admin Dashboard
        Route::get('/', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        // ── Homestays ────────────────────────────────────────────────────────

        Route::get('/homestays', [AdminController::class, 'homestays'])
            ->name('homestays');

        Route::get('/homestays/{id}/edit', [AdminController::class, 'editHomestay'])
            ->name('homestays.edit');

        Route::put('/homestays/{id}', [AdminController::class, 'updateHomestay'])
            ->name('homestays.update');

        Route::delete('/homestays/{id}', [AdminController::class, 'destroyHomestay'])
            ->name('homestays.destroy');


        // ── Admin Reviews ───────────────────────────────────────────────────

        Route::get('/reviews', [AdminController::class, 'reviews'])
            ->name('reviews');

        Route::delete('/reviews/{id}', [AdminController::class, 'destroyReview'])
            ->name('reviews.destroy');


        // ── Hosts ───────────────────────────────────────────────────────────

        Route::get('/hosts', [AdminController::class, 'hosts'])
            ->name('hosts');

        Route::post('/hosts/{id}', [AdminController::class, 'assignHost'])
            ->name('hosts.assign');

        Route::delete('/hosts/{id}', [AdminController::class, 'removeHost'])
            ->name('hosts.remove');


        // ── Provinces ───────────────────────────────────────────────────────

        Route::resource('provinces', ProvinceController::class);


        // ── Amenities ───────────────────────────────────────────────────────

        Route::resource('amenities', AmenityController::class);


       // ── User Management ─────────────────────────────────────────────────

        Route::get('/users', [AdminController::class, 'users'])
            ->name('users.index');

        Route::post('/users', [AdminController::class, 'storeUser'])
            ->name('users.store');

        Route::put('/users/{id}', [AdminController::class, 'updateUser'])
            ->name('users.update');

        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])
            ->name('users.destroy');

        // ── Settings ─────────────────────────────────────────────────────────

        Route::get('/settings', [SettingController::class, 'index'])
            ->name('settings.index');

        Route::post('/settings/maintenance', [SettingController::class, 'toggleMaintenance'])
            ->name('settings.maintenance');
    });