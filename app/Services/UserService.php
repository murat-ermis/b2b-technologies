<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
  protected UserRepository $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function findOneByEmail(string $email): ?User
  {
    return $this->userRepository->findOneByEmail($email);
  }

  public function create(array $data): User
  {
    return $this->userRepository->create($data);
  }

  public function hashCheck(string $password, string $hashedPassword): bool
  {
    return Hash::check($password, $hashedPassword);
  }
}
