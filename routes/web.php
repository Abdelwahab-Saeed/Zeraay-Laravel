
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Admin authentication routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin routes - Protected by admin middleware
Route::prefix('admin')->name('admin.')->middleware(['web', 'admin'])->group(function () {
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    // Categories
    Route::resource('categories', CategoryController::class)->except(['show']);
    
    // Products
    Route::resource('products', ProductController::class)->except(['show']);
    
    // Users
    Route::resource('users', UserController::class)->except(['create', 'store']);
});

