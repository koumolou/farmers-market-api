<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FarmerController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RepaymentController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Public
Route::post('/login', [AuthController::class, 'login']);

// Authenticated
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    // Admin only — manages supervisors
    Route::middleware('role:admin')->group(function () {
        Route::get('supervisors',         [UserController::class, 'index'])->name('supervisors.index');
        Route::post('supervisors',        [UserController::class, 'store'])->name('supervisors.store');
        Route::get('supervisors/{id}',    [UserController::class, 'show'])->name('supervisors.show');
        Route::put('supervisors/{id}',    [UserController::class, 'update'])->name('supervisors.update');
        Route::delete('supervisors/{id}', [UserController::class, 'destroy'])->name('supervisors.destroy');
    });

    // Admin + Supervisor — manage operators, categories, products
    Route::middleware('role:admin,supervisor')->group(function () {
        Route::get('operators',           [UserController::class, 'index'])->name('operators.index');
        Route::post('operators',          [UserController::class, 'store'])->name('operators.store');
        Route::get('operators/{id}',      [UserController::class, 'show'])->name('operators.show');
        Route::put('operators/{id}',      [UserController::class, 'update'])->name('operators.update');
        Route::delete('operators/{id}',   [UserController::class, 'destroy'])->name('operators.destroy');

        Route::apiResource('categories',  CategoryController::class);
        Route::apiResource('products',    ProductController::class);
    });

    // All authenticated roles
    Route::get('farmers/search',              [FarmerController::class, 'search']);
    Route::apiResource('farmers',             FarmerController::class);

    Route::post('transactions/checkout',      [TransactionController::class, 'checkout']);

    Route::post('repayments',                 [RepaymentController::class, 'store']);
    Route::get('farmers/{farmer}/repayments', [RepaymentController::class, 'farmerRepayments']);
});