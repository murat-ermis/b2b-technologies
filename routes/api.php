<?php

use App\Http\Middleware\ApiAuthMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware(ApiAuthMiddleware::class);

Route::prefix('/products')->group(function () {
  Route::get('/', [ProductController::class, 'index']);
  Route::post('/', [ProductController::class, 'store']);
  Route::put('/{product}', [ProductController::class, 'update']);
  Route::delete('/{product}', [ProductController::class, 'destroy']);
})->middleware(ApiAuthMiddleware::class);

Route::fallback(function () {
  return response()->json(['message' => 'Not Found'], 404);
});
