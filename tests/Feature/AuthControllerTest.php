<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

describe('AuthController', function () {
  beforeEach(function () {
    $this->user = User::factory()->create([
      'email' => 'user@example.com',
      'password' => bcrypt('password'),
      'role' => 'customer',
    ]);
  });

  it('can register a new user', function () {
    $payload = [
      'name' => 'Test User',
      'email' => 'newuser@example.com',
      'password' => 'password',
      'role' => 'customer',
    ];
    $this->postJson('/api/register', $payload)
      ->assertCreated()
      ->assertJsonStructure(['user', 'token']);
  });

  it('cannot register with existing email', function () {
    $payload = [
      'name' => 'Test User',
      'email' => 'user@example.com',
      'password' => 'password',
      'role' => 'customer',
    ];
    $this->postJson('/api/register', $payload)
      ->assertStatus(422);
  });

  it('can login with correct credentials', function () {
    $payload = [
      'email' => 'user@example.com',
      'password' => 'password',
    ];
    $this->postJson('/api/login', $payload)
      ->assertOk()
      ->assertJsonStructure(['user', 'token']);
  });

  it('cannot login with wrong credentials', function () {
    $payload = [
      'email' => 'user@example.com',
      'password' => 'wrongpassword',
    ];
    $this->postJson('/api/login', $payload)
      ->assertStatus(401);
  });

  it('can logout', function () {
    $payload = [
      'email' => 'user@example.com',
      'password' => 'password',
    ];
    $login = $this->postJson('/api/login', $payload)
      ->assertOk();
    $token = $login->json('token');
    $this->withHeader('Authorization', 'Bearer ' . $token)
      ->postJson('/api/logout')
      ->assertOk()
      ->assertJsonFragment(['message' => 'Logged out']);
  });
});

