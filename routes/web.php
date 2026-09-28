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


// =====================================================
// Public Routes
// =====================================================

Route::get('/', [HotelController::class, 'home'])
    ->name('home');

Route::get('/hotels', [HotelController::class, 'search'])
    ->name('hotels.index');

Route::get('/hotels/{id}', [HotelController::class, 'show'])
    ->name('hotels.show');

Route::get('/about', [ContactController::class, 'about'])
    ->name('about');

Route::get('/contact', [ContactController::class, 'contact'])
    ->name('contact');


// =====================================================
// Authentication
// =====================================================

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


// =====================================================
// Profile
// =====================================================

Route::middleware('auth')
    ->prefix('profile')
    ->group(function () {

        Route::get('/', [ProfileController::class, 'index'])
            ->name('profile.index');

        Route::put('/update', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::put('/password', [ProfileController::class, 'updatePassword'])
            ->name('profile.password');

        Route::get('/reviews', [ProfileController::class, 'reviews'])
            ->name('profile.reviews');
    });


// =====================================================
// Reviews
// =====================================================

Route::middleware('auth')->group(function () {

    Route::post('/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store');

    Route::get('/my-reviews', [ReviewController::class, 'myReviews'])
        ->name('reviews.my');

    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])
        ->name('reviews.destroy');
});


// =====================================================
// Admin
// =====================================================

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // -------------------------------------------------
        // Dashboard
        // -------------------------------------------------

        Route::get('/', [AdminController::class, 'dashboard'])
            ->name('dashboard');


        // -------------------------------------------------
        // Homestays
        // -------------------------------------------------

        // View all homestays
        Route::get('/homestays', [AdminController::class, 'homestays'])
            ->name('homestays');

        // Add homestay form
        Route::get('/homestays/create', [AdminController::class, 'createHomestay'])
            ->name('homestays.create');

        // Save new homestay
        Route::post('/homestays', [AdminController::class, 'storeHomestay'])
            ->name('homestays.store');

        // Edit homestay form
        Route::get('/homestays/{id}/edit', [AdminController::class, 'editHomestay'])
            ->name('homestays.edit');

        // Update homestay
        Route::put('/homestays/{id}', [AdminController::class, 'updateHomestay'])
            ->name('homestays.update');

        // Delete homestay
        Route::delete('/homestays/{id}', [AdminController::class, 'destroyHomestay'])
            ->name('homestays.destroy');


        // -------------------------------------------------
        // Reviews
        // -------------------------------------------------

        Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');

        Route::get('/reviews/{id}/edit', [AdminController::class, 'editReview'])
            ->name('reviews.edit');

        Route::put('/reviews/{id}', [AdminController::class, 'updateReview'])
            ->name('reviews.update');

        Route::delete('/reviews/{id}', [AdminController::class, 'destroyReview'])
            ->name('reviews.destroy');


        // -------------------------------------------------
        // Provinces
        // -------------------------------------------------

        Route::resource('provinces', ProvinceController::class);


        // -------------------------------------------------
        // Amenities
        // -------------------------------------------------

        Route::resource('amenities', AmenityController::class);


        // -------------------------------------------------
        // User Management
        // -------------------------------------------------

        Route::get('/users', [AdminController::class, 'users'])
            ->name('users.index');

        Route::post('/users', [AdminController::class, 'storeUser'])
            ->name('users.store');

        Route::put('/users/{id}', [AdminController::class, 'updateUser'])
            ->name('users.update');

        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])
            ->name('users.destroy');


        // -------------------------------------------------
        // Settings
        // -------------------------------------------------

        Route::get('/settings', [SettingController::class, 'index'])
            ->name('settings.index');

        Route::post('/settings/maintenance', [SettingController::class, 'toggleMaintenance'])
            ->name('settings.maintenance');
    });