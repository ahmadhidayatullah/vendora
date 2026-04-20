<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\VendorController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me',      [AuthController::class, 'me']);

    // Vendors
    Route::apiResource('vendors', VendorController::class);

    // Products (nested under vendor)
    Route::apiResource('vendors.products', ProductController::class);

    // Orders
    Route::apiResource('orders', OrderController::class)->only(['index', 'show', 'store']);

    // Payment
    Route::post('orders/{order}/pay', [PaymentController::class, 'pay']);
    Route::post('webhook/payment', [PaymentController::class, 'webhook'])
        ->withoutMiddleware('auth:sanctum');  // webhooks are not user-authenticated

});
