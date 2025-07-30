<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['auth:api'])->group(function () {
  Route::post('/logout', [AuthController::class, 'logout']);

  Route::get('/products', [ProductController::class, 'index'])->middleware(['role:[admin|customer]']);
  Route::post('/products', [ProductController::class, 'store'])->middleware(['role:[admin]']);;
  Route::put('/products/{product}', [ProductController::class, 'update'])->middleware(['role:[admin]']);
  Route::delete('/products/{product}', [ProductController::class, 'destroy'])->middleware(['role:[admin]']);;

  // Order routes
  Route::get('/orders', [OrderController::class, 'index'])->middleware(['role:[admin|customer]']);
  Route::post('/orders', [OrderController::class, 'store'])->middleware(['role:[customer]']);
  Route::get('/orders/{id}', [OrderController::class, 'show'])->middleware(['role:[admin|customer]']);
});

Route::fallback(function () {
  return response()->json(['message' => 'Not Found'], 404);
});
