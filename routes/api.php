<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentCallbackController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/payment/callback', [PaymentCallbackController::class, 'handlePaymentCallback'])
    ->middleware(['api'])
    ->name('payment.callback');