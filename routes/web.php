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

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'authenticate']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class)->except(['create', 'edit']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});


Route::resource('branches', BranchesController::class);
Route::resource('products', ProductController::class);
Route::resource('stocks', StockController::class);
Route::resource('transactions', TransactionController::class);
Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
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

// Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
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
