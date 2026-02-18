
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\TechnicalSupportController;

use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('/contact', [LandingController::class, 'sendContactEmail'])->name('contact.send');

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

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
    
    // Banners
    Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);

    // Addresses & Phone Numbers
    Route::resource('addresses', \App\Http\Controllers\Admin\AddressController::class);
    Route::resource('phone_numbers', \App\Http\Controllers\Admin\PhoneNumberController::class);

    // Common Questions
    Route::resource('common_questions', \App\Http\Controllers\Admin\CommonQuestionController::class);
    
    // Companies
    Route::resource('companies', CompanyController::class)->except(['show']);
    
    // Products
    Route::get('products/stock', [ProductController::class, 'stock'])->name('products.stock');
    Route::resource('products', ProductController::class)->except(['show']);
    
    // Users
    Route::resource('users', UserController::class)->except(['create', 'store']);
    
    // Coupons
    Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);

    // Payment Methods
    Route::resource('payment_methods', \App\Http\Controllers\Admin\PaymentMethodController::class)->except(['show']);

    // Orders
    Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'update'])->name('orders.update');

    // Technical Support
    Route::resource('technical_supports', TechnicalSupportController::class)->except(['show']);

    // Chat routes
    Route::get('chats', [\App\Http\Controllers\Admin\ChatController::class, 'index'])->name('chats.index');
    Route::get('chats/{id}', [\App\Http\Controllers\Admin\ChatController::class, 'show'])->name('chats.show');
    Route::post('chats/{id}/reply', [\App\Http\Controllers\Admin\ChatController::class, 'store'])->name('chats.store');
    Route::post('chats/{id}/read', [\App\Http\Controllers\Admin\ChatController::class, 'markRead'])->name('chats.read');

    // Notifications
    Route::get('notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/create', [\App\Http\Controllers\Admin\NotificationController::class, 'create'])->name('notifications.create');
    Route::post('notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'store'])->name('notifications.store');
});

