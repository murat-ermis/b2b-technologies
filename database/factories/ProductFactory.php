<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'name' => $this->faker->words(2, true),
      'sku' => $this->faker->unique()->bothify('SKU-####'),
      'price' => $this->faker->randomFloat(2, 10, 1000),
      'stock_quantity' => $this->faker->numberBetween(0, 100),
      'created_at' => now(),
      'updated_at' => now(),
    ];
  }
}
