<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
  public function findOneByEmail(string $email): ?User
  {
    return User::where('email', $email)->first();
  }

  public function create(array $data): User
  {
    return User::create($data);
  }
}

