<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('products')->group(function () {
    Route::get('/', [ProductsController::class, 'index']);
    Route::post('/', [ProductsController::class, 'store']);
    Route::get('{id}', [ProductsController::class, 'show']);
    Route::put('{id}', [ProductsController::class, 'update']);
    Route::delete('{id}', [ProductsController::class, 'destroy']);
});
