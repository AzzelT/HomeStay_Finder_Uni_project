<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ContactController;

// ─── Panha's existing routes (DO NOT TOUCH) ──────────────────────────────────
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/profile', function () {
    return view('profile');
})->middleware('auth');

// ─── Tola's Public Routes (no login required) ────────────────────────────────

// Home page
Route::get('/', [HotelController::class, 'home'])->name('home');

// Search / browse all hotels
Route::get('/hotels', [HotelController::class, 'search'])->name('hotels.index');

// Hotel detail page
Route::get('/hotels/{id}', [HotelController::class, 'show'])->name('hotels.show');

// About Us
Route::get('/about', [ContactController::class, 'about'])->name('about');

// Contact Us
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
