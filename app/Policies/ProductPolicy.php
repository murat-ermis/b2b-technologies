<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;

class ProductPolicy
{
  public function view(User $user): bool
  {
    return in_array($user->role, ['admin', 'customer']);
  }

  public function create(User $user): bool
  {
    return $user->role === 'admin';
  }

  public function update(User $user): bool
  {
    return $user->role === 'admin';
  }

  public function delete(User $user): bool
  {
    return $user->role === 'admin';
  }
}

