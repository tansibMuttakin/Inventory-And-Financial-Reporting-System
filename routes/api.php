<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\FinancialReportController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::prefix('products')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ProductsController::class, 'index']);
    Route::post('/', [ProductsController::class, 'store']);
    Route::get('/{product}', [ProductsController::class, 'show']);
    Route::put('/{product}', [ProductsController::class, 'update']);
    Route::delete('/{product}', [ProductsController::class, 'destroy']);
});

Route::prefix('sales')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [SaleController::class, 'index']);
    Route::post('/', [SaleController::class, 'store']);
    Route::get('/{sale}', [SaleController::class, 'show']);
    Route::put('/{sale}', [SaleController::class, 'update']);
    Route::delete('/{sale}', [SaleController::class, 'destroy']);
});

Route::prefix('journals')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [JournalController::class, 'index']);
    Route::get('/summary', [JournalController::class, 'summary']);
});

Route::get('/financial-report', [FinancialReportController::class, 'index']);