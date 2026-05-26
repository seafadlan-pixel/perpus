<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\WebAuthController;

// Web Authentication Routes
Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [WebAuthController::class, 'login']);
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

// Protected Routes (Wajib Login)
Route::middleware('auth')->group(function () {
    // Public Visitor Routes
    Route::get('/', [PublicController::class, 'index'])->name('public.index');
    Route::get('/book/{id}', [PublicController::class, 'show'])->name('public.show');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/', function () {
        return redirect('/admin/books');
    });
    Route::resource('books', BookController::class);
});