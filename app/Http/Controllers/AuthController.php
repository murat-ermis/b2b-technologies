<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
  protected UserService $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function register(RegisterRequest $request): JsonResponse
  {
    try {
      $user = $this->userService->create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password,
        'role' => $request->role ?? 'customer',
      ]);

      $token = $user->createToken('api_token')->plainTextToken;

      return response()->json([
        'user' => UserResource::make($user),
        'token' => $token,
      ], 201);

    } catch (\Exception $e) {
      return response()->json(['message' => 'Registration failed'], 500);
    }
  }

  public function login(LoginRequest $request): JsonResponse
  {
    try {
      $user = $this->userService->findOneByEmail($request->email);

      if (!$user) {
        return response()->json(['message' => 'Invalid credentials'], 401);
      }

      if ($this->userService->hashCheck($request->password, $user->password) === false) {
        return response()->json(['message' => 'Invalid credentials'], 401);
      }

      $user->tokens()->delete();

      $token = $user->createToken('api_token')->plainTextToken;
      return response()->json([
        'user' => UserResource::make($user),
        'token' => $token,
      ]);

    } catch (\Exception $e) {
      return response()->json(['message' => 'Login failed'], 500);
    }
  }

  public function logout(Request $request): JsonResponse
  {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Logged out']);
  }
}
