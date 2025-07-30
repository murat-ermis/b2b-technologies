<?php

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
      'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions): void {
    //
  })->create();
