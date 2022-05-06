<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\ProductController as ProductFrontController;
use App\Http\Controllers\Public\OrderController as OrderFrontController;
use App\Http\Controllers\Public\CouponController as CouponFrontController;
use App\Http\Controllers\Public\CartController as CartFrontController;
use App\Http\Controllers\Public\{HomeController, CountryCityStateController};
use App\Http\Controllers\Auth\ApiAuthController;

// ------------------------------------------------ Frontend Routes-------->>>
Route::group(['prefix' => '/front', 'middleware' => ['cors', 'json.response']], function () {
    Route::get('/countries', [CountryCityStateController::class, 'countries']);
    Route::get('/states/{country}', [CountryCityStateController::class, 'states']);
    Route::get('/states-single/{state}', [CountryCityStateController::class, 'state']);
    Route::get('/cities/{state}', [CountryCityStateController::class, 'cities']);
    Route::get('/user-exemptions', [CountryCityStateController::class, 'exemptions']);
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/menu', [HomeController::class, 'menu']);
    Route::post('/cart', [CartFrontController::class, 'index']);
    Route::get('/cart/{cart}', [CartFrontController::class, 'get']);
    Route::post('/cart/{cart}', [CartFrontController::class, 'item']);
    Route::get('/products', [ProductFrontController::class, 'index']);
    Route::post('/products-viaslug', [ProductFrontController::class, 'getViaSlug']);
    Route::get('/category/{category}', [ProductFrontController::class, 'category']);
    Route::get('/categories', [ProductFrontController::class, 'categories']);
    Route::get('/products/{slug}', [ProductFrontController::class, 'get']);
    Route::post('/products/quote', [ProductFrontController::class, 'quote']);
    Route::post('/quote-form', [ProductFrontController::class, 'quoteform']);
    Route::post('/coupon', [CouponFrontController::class, 'view']);
    Route::post('/orders', [OrderFrontController::class, 'store']);
    Route::get('/orders/{order}', [OrderFrontController::class, 'get']);
    Route::post('/register', [ApiAuthController::class, 'register']);
    Route::post('/login', [ApiAuthController::class, 'login']);

    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('/logout', [ApiAuthController::class, 'logout']);
        Route::put('/updateprofile', [ApiAuthController::class, 'updateprofile']);
        Route::get('/me', function (Request $request) {
            $notificationsCount = $request->user()->unreadNotifications()->count();
            $user = $request->user();
            $user->notification_count = $notificationsCount;
            return $user;
        });
        Route::get('/orders', [OrderFrontController::class, 'index']);
    });

});
