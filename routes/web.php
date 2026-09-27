<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/profile', function () {
    return view('profile');
})->middleware('auth');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/homestays', [AdminController::class, 'homestays'])->name('homestays');
    Route::get('/homestays/{id}/edit', [AdminController::class, 'editHomestay'])->name('homestays.edit');
    Route::put('/homestays/{id}', [AdminController::class, 'updateHomestay'])->name('homestays.update');
    Route::delete('/homestays/{id}', [AdminController::class, 'destroyHomestay'])->name('homestays.destroy');

    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');
    Route::delete('/reviews/{id}', [AdminController::class, 'destroyReview'])->name('reviews.destroy');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    Route::get('/hosts', [AdminController::class, 'hosts'])->name('hosts');
    Route::post('/hosts/{id}', [AdminController::class, 'assignHost'])->name('hosts.assign');
    Route::delete('/hosts/{id}', [AdminController::class, 'removeHost'])->name('hosts.remove');
});
