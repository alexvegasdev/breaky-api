<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DonationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SaleController;

//Routes for the API endpoints of the application.

Route::apiResource('categories', CategoryController::class)->only(['index', 'store', 'update', 'destroy']);
Route::apiResource('products', ProductController::class)->only(['index', 'store', 'update', 'destroy']);
Route::apiResource('sales', SaleController::class)->only(['index', 'store', 'update', 'destroy']);
Route::apiResource('donations', DonationController::class)->only(['index', 'store', 'update', 'destroy']);