<?php

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('UserService', function () {
    beforeEach(function () {
        $this->service = app(UserService::class);
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
        $user = $this->service->create($data);
        expect($user)->not()->toBeNull()
          ->and($user->name)->toBe('New User')
          ->and($user->email)->toBe('newuser@example.com');
    });

    it('can find a user by email', function () {
        $user = $this->service->findOneByEmail('testuser@example.com');
        expect($user)->not()->toBeNull()
          ->and($user->name)->toBe('Test User');
    });

    it('can check password hash', function () {
        $result = $this->service->hashCheck('password', $this->user->password);
        expect($result)->toBeTrue();
    });

    it('returns false for wrong password', function () {
        $result = $this->service->hashCheck('wrongpassword', $this->user->password);
        expect($result)->toBeFalse();
    });
});

