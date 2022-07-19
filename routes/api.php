<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\{BannerController, BrandController, CategoryController, CityController, CountryController, RoleController, PermissionController, ProductController, UserController, CouponController, FaqController, InquiryController, ProductQuoteController, OrderController, StateController, UserExemptionController, VariantController};
use App\Http\Controllers\Auth\ApiAuthController;


// ------------------------------------------------Backend Routes--------->>>
Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login', [ApiAuthController::class, 'login']);
    Route::post('/register', [ApiAuthController::class, 'register']);
});

Route::group(['middleware' => ['cors', 'json.response', 'auth:api']], function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::put('/updateprofile', [ApiAuthController::class, 'updateprofile']);

    /*Company resource*/
    // Route::apiResource('departments', DepartmentController::class);
    Route::apiResource('file', FileController::class)->only([
        'store', 'destroy', 'index'
    ]);
    Route::post('/file/{table}/{id}/{type}', [FileController::class, 'findByTable']);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('banners', BannerController::class);
    Route::apiResource('permissions', PermissionController::class);
    Route::get('GetAllModules', [PermissionController::class, 'GetAllModules']);
    Route::apiResource('user', UserController::class);
    Route::apiResource('user-exemptions', UserExemptionController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('variants', VariantController::class);
    Route::apiResource('coupons', CouponController::class);
    Route::apiResource('faqs', FaqController::class);
    Route::apiResource('inquiries', InquiryController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('brands', BrandController::class);
    Route::apiResource('countries', CountryController::class);
    Route::apiResource('states', StateController::class);
    Route::apiResource('product-quotes', ProductQuoteController::class);
    Route::apiResource('orders', OrderController::class);

    Route::get('/order-stripedetails/{order}', [OrderController::class, 'stripedetails']);
    Route::get('/capture-order/{order}', [OrderController::class, 'capture']);
    Route::get('/refund-order/{order}', [OrderController::class, 'refund']);

    //additional
    // Route::post('/a/products/uploadcsv', [ProductController::class, 'uploadcsv']);
});
Route::middleware('auth:api')->get('/me', function (Request $request) {
    $notificationsCount = $request->user()->unreadNotifications()->count();
    $Role_Permissions = $request->user()->getPermissionsViaRoles();
    $user = $request->user();
    $user->notification_count = $notificationsCount;
    $user->Role_Permissions = $Role_Permissions;
    return $user;
});
Route::middleware('auth:api')->get('/notifications', function (Request $request) {
    $notifications = $request->user()->notifications()->paginate(50);
    $request->user()->notifications()->paginate(50)->markAsRead();
    return $notifications;
});

//importing
Route::post('/import-brands', [BrandController::class, 'import']);
