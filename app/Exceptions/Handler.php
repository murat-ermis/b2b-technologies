<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
  protected function unauthenticated($request, AuthenticationException $exception): Response|JsonResponse|RedirectResponse
  {
    if ($request->expectsJson()) {
      return response()->json(['message' => 'Forbidden'], 403);
    }
    return redirect()->guest(route('login'));
  }
}

