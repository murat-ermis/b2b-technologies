<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param Request $request
   * @param Closure $next
   * @param string $roles
   * @return mixed
   */
  public function handle(Request $request, Closure $next, string $roles): mixed
  {
    $user = Auth::user();
    if (!$user) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    if (!in_array($user->role, array_column(Role::cases(), 'value'))) {
      return response()->json(['message' => 'Forbidden'], 403);
    }

    $roleList = array_map('trim', explode('|', trim($roles, '[]')));
    if (!in_array($user->role, $roleList)) {
      return response()->json(['message' => 'Forbidden'], 403);
    }

    return $next($request);
  }
}
