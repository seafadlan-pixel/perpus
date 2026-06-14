<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\AdminBorrowingController;

// Web Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [WebAuthController::class, 'login']);
    Route::get('/register', [WebAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [WebAuthController::class, 'register']);
    Route::get('/forgot-password', [WebAuthController::class, 'showForgotPassword'])->name('password.forgot');
});
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

// Protected Routes (Wajib Login)
Route::middleware('auth')->group(function () {
    // Public Visitor Routes
    Route::get('/', [PublicController::class, 'index'])->name('public.index');
    Route::get('/book/{id}', [PublicController::class, 'show'])->name('public.show');

    // User Borrowing Routes
    Route::get('/borrow/{bookId}', [BorrowingController::class, 'create'])->name('borrow.create');
    Route::post('/borrow', [BorrowingController::class, 'store'])->name('borrow.store');
    Route::get('/my-borrowings', [BorrowingController::class, 'myBorrowings'])->name('borrow.my');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/', function () {
        return redirect('/admin/books');
    });
    Route::resource('books', BookController::class);

    // Borrowing Management
    Route::get('borrowings', [AdminBorrowingController::class, 'index'])->name('admin.borrowings.index');
    Route::get('borrowings/create', [AdminBorrowingController::class, 'createForAdmin'])->name('admin.borrowings.create');
    Route::post('borrowings/create', [AdminBorrowingController::class, 'storeForAdmin'])->name('admin.borrowings.store');
    Route::patch('borrowings/{id}/approve', [AdminBorrowingController::class, 'approve'])->name('admin.borrowings.approve');
    Route::patch('borrowings/{id}/reject', [AdminBorrowingController::class, 'reject'])->name('admin.borrowings.reject');
    Route::patch('borrowings/{id}/return', [AdminBorrowingController::class, 'returnBook'])->name('admin.borrowings.return');
    Route::patch('borrowings/{id}/fine', [AdminBorrowingController::class, 'updateFine'])->name('admin.borrowings.update_fine');
    Route::delete('borrowings/{id}', [AdminBorrowingController::class, 'destroy'])->name('admin.borrowings.destroy');

    // User Management
    Route::get('users', [App\Http\Controllers\AdminUserController::class, 'index'])->name('admin.users.index');
    Route::patch('users/{user}/toggle-active', [App\Http\Controllers\AdminUserController::class, 'toggleActive'])->name('admin.users.toggle_active');
    Route::patch('users/{user}/reset-password', [App\Http\Controllers\AdminUserController::class, 'resetPassword'])->name('admin.users.reset_password');
});