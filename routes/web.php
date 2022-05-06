<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{PaymentController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('payment/{payment}',function(){
    return view('welcome');
})->name('payment.link');
Route::get('payment/{payment}/stripe-success',[PaymentController::class,'stripeSuccess'])->name('payment.link.success');
Route::get('/company/user/getallusers', [CompanyController::class,'getallusers']);

Route::get('/{any?}', function () {
    return view('welcome');
})->where('any','.*');
