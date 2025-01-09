<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// User routes
Route::apiResource('users', UserController::class);

// Branch routes
Route::apiResource('branches', BranchesController::class);

// Product routes
Route::apiResource('products', ProductController::class);

// Stock routes
Route::apiResource('stocks', StockController::class);

// Transaction routes
Route::apiResource('transactions', TransactionController::class);
