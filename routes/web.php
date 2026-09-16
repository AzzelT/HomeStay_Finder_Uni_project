<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

// Hengleap's Controllers (Role 3)
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingController;

// Ratana's Controllers (Role 5) - Uncomment when Ratana creates them
// use App\Http\Controllers\AdminDashboardController;
// use App\Http\Controllers\AdminHotelController;
// use App\Http\Controllers\AdminReviewController;


// ─── Tola's Public Routes (no login required) ────────────────────────────────
Route::get('/', [HotelController::class, 'home'])->name('home');
Route::get('/hotels', [HotelController::class, 'search'])->name('hotels.index');
Route::get('/hotels/{id}', [HotelController::class, 'show'])->name('hotels.show');
Route::get('/about', [ContactController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');


// ─── Auth Routes (Panha's role — built by Tola) ──────────────────────────────
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// ─── Profile Routes (login required) ─────────────────────────────────────────
Route::middleware('auth')->prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/reviews', [ProfileController::class, 'reviews'])->name('profile.reviews');
});


// ─── Hengleap's Routes (Role 3) ──────────────────────────────────────────────

// Guest routes (login required)
Route::middleware(['auth'])->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/my-reviews', [ReviewController::class, 'myReviews'])->name('reviews.my');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Admin routes (login + admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Province CRUD
    Route::resource('provinces', ProvinceController::class);

    // Amenity CRUD
    Route::resource('amenities', AmenityController::class);

    // User Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::put('/users/{user}/ban', [AdminUserController::class, 'ban'])->name('admin.users.ban');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    // Settings / Maintenance Mode
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings/maintenance', [SettingController::class, 'toggleMaintenance'])->name('admin.settings.maintenance');
});


// ─── Ratana's Routes (Role 5) ────────────────────────────────────────────────
// Uncomment when Ratana creates her controllers
/*
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('hotels', AdminHotelController::class);
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('admin.reviews.index');
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('admin.reviews.destroy');
});
*/