<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'user_id' => \App\Models\User::factory(),
      'status' => 'pending',
      'total_price' => $this->faker->randomFloat(2, 10, 1000),
      'created_at' => now(),
      'updated_at' => now(),
    ];
  }
}
