<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Product;
use App\Policies\ProductPolicy;

class AuthServiceProvider extends ServiceProvider
{
  protected $policies = [
    Product::class => ProductPolicy::class,
  ];

  public function boot(): void
  {
    $this->registerPolicies();
  }
}

