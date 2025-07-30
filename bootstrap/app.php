<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    api: __DIR__ . '/../routes/api.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware): void {
    // Register API middleware
    $middleware->alias([
      'role' => RoleMiddleware::class,
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions): void {
    //
  })->create();
