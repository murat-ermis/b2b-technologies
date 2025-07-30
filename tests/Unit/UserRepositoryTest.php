<?php

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('UserRepository', function () {
  beforeEach(function () {
    $this->repo = app(UserRepository::class);
    $this->user = User::factory()->create([
      'name' => 'Test User',
      'email' => 'testuser@example.com',
      'password' => bcrypt('password'),
      'role' => 'customer',
    ]);
  });

  it('can create a user', function () {
    $data = [
      'name' => 'New User',
      'email' => 'newuser@example.com',
      'password' => 'password',
      'role' => 'customer',
    ];
    $user = $this->repo->create($data);
    expect($user)->not()->toBeNull()
      ->and($user->name)->toBe('New User')
      ->and($user->email)->toBe('newuser@example.com');
  });

  it('can find a user by email', function () {
    $user = $this->repo->findOneByEmail('testuser@example.com');
    expect($user)->not()->toBeNull()
      ->and($user->name)->toBe('Test User');
  });
});

