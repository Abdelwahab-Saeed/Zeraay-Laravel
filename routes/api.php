<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\WishlistController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/update-profile', [AuthController::class, 'updateProfile']);
    
    // Cart routes
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::put('/cart/{cartItem}', [CartController::class, 'update']);
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy']);
    Route::delete('/cart', [CartController::class, 'clear']);
    
    // Wishlist routes
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist', [WishlistController::class, 'store']);
    Route::delete('/wishlist/{wishlistItem}', [WishlistController::class, 'destroy']);
    Route::post('/wishlist/{wishlistItem}/move-to-cart', [WishlistController::class, 'moveToCart']);
    
    // Payment Methods
    Route::get('/payment-methods', [\App\Http\Controllers\API\PaymentMethodController::class, 'index']);
    
    // Coupon routes
    Route::post('/coupons/redeem', [\App\Http\Controllers\API\CouponController::class, 'apply']);

    // Order routes
    Route::get('/orders', [\App\Http\Controllers\API\OrderController::class, 'index']);
    Route::post('/orders', [\App\Http\Controllers\API\OrderController::class, 'store']);
    Route::get('/orders/{order}', [\App\Http\Controllers\API\OrderController::class, 'show']);

    // Chat routes
    Route::get('/chat', [\App\Http\Controllers\API\ChatController::class, 'index']);
    Route::post('/chat', [\App\Http\Controllers\API\ChatController::class, 'store']);
    Route::post('/chat/read', [\App\Http\Controllers\API\ChatController::class, 'markRead']);
});

// Public API routes for mobile app
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/companies', [\App\Http\Controllers\API\CompanyController::class, 'index']);
Route::get('/companies/{id}', [\App\Http\Controllers\API\CompanyController::class, 'show']);

Route::get('/technical-support', [\App\Http\Controllers\API\TechnicalSupportController::class, 'index']);

Route::get('/banners', [\App\Http\Controllers\API\BannerController::class, 'index']);
Route::get('/banners/{id}', [\App\Http\Controllers\API\BannerController::class, 'show']);

Route::get('/addresses', [\App\Http\Controllers\API\AddressController::class, 'index']);
Route::get('/phone-numbers', [\App\Http\Controllers\API\PhoneNumberController::class, 'index']);
Route::get('/common-questions', [\App\Http\Controllers\API\CommonQuestionController::class, 'index']);








