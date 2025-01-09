<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionDetailController;

// Route ke halaman utama (welcome view)
Route::get('/', function () {
    return view('welcome');
});

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

// // User routes
// Route::apiResource('users', UserController::class);

// // Branch routes
// Route::apiResource('branches', BranchesController::class);

// // Product routes
// Route::apiResource('products', ProductController::class);

// // Stock routes
// Route::apiResource('stocks', StockController::class);

// // Transaction routes
// Route::apiResource('transactions', TransactionController::class);

Route::resource('branches', BranchesController::class);
Route::resource('products', ProductController::class);
Route::resource('stocks', StockController::class);
Route::resource('transactions', TransactionController::class);
Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
// Route::resource('DetailTransactions', TransactionDetailController::class);

// Jika ingin manual route ke specific views untuk branch, product, stock, dan transaction
// Route::get('/branches', function () {
//     return view('branches.index');
// })->name('branches.index');

// Route::get('/products', function () {
//     return view('products.index');
// })->name('products.index');

// Route::get('/stocks', function () {
//     return view('stocks.index');
// })->name('stocks.index');

// Route::get('/transactions', function () {
//     return view('transactions.index');
// })->name('transactions.index');
