<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\VendorController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    // Vendors
    Route::apiResource('vendors', VendorController::class);

    // Products (nested under vendor)
    Route::apiResource('vendors.products', ProductController::class);

    // Orders
    Route::apiResource('orders', OrderController::class)->only(['index', 'show', 'store']);

});