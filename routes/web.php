<?php

use Illuminate\Support\Facades\Route;


// Existing Controllers
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ContactController;

// Hengleap's Controllers (Role 3)
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingController;

// Ratana's Controllers (Role 5) - Uncomment these when Ratana creates them
// use App\Http\Controllers\AdminDashboardController;
// use App\Http\Controllers\AdminHotelController;
// use App\Http\Controllers\AdminReviewController;


// ─── Panha's Routes (Auth & Profile) ─────────────────────────────────────────
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/profile', function () {
    return view('profile');
})->middleware('auth');


// ─── Tola's Public Routes (No login required) ────────────────────────────────
Route::get('/', [HotelController::class, 'home'])->name('home');
Route::get('/hotels', [HotelController::class, 'search'])->name('hotels.index');
Route::get('/hotels/{id}', [HotelController::class, 'show'])->name('hotels.show');
Route::get('/about', [ContactController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');


// ─── Hengleap's Routes (Role 3: Reviews, Settings, User Management) ──────────

// 1. User/Guest Routes (Requires Login)
Route::middleware(['auth'])->group(function () {
    // User submits a review
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // User views their own reviews
    Route::get('/my-reviews', [ReviewController::class, 'myReviews'])->name('reviews.my');

    // User deletes their own review
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// 2. Admin Routes (Requires Login + Admin Middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Province CRUD
    Route::resource('provinces', ProvinceController::class);

    // Amenity CRUD
    Route::resource('amenities', AmenityController::class);

    // User Management (Ban/Unban & Delete)
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::put('/users/{user}/ban', [AdminUserController::class, 'ban'])->name('admin.users.ban');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    // Site Settings (Maintenance Mode)
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings/maintenance', [SettingController::class, 'toggleMaintenance'])->name('admin.settings.maintenance');
});


// ─── Ratana's Routes (Role 5: Admin Dashboard, Hotels, Admin Reviews) ────────
// (Ratana will fill this in later. Example structure provided below)
/*
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('hotels', AdminHotelController::class);
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('admin.reviews.index');
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('admin.reviews.destroy');
});
*/
