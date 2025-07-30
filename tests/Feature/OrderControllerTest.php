<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

describe('OrderController', function () {
  beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'customer']);
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->product = Product::factory()->create(['stock_quantity' => 10, 'price' => 100]);
  });

  it('customer can see their own orders', function () {
    $order = Order::factory()->create(['user_id' => $this->user->id]);
    $this->actingAs($this->user, 'api')
      ->getJson('/api/orders')
      ->assertOk()
      ->assertJsonFragment(['user_id' => $this->user->id]);
  });

  it('admin can see all orders', function () {
    $order = Order::factory()->create();
    $this->actingAs($this->admin, 'api')
      ->getJson('/api/orders')
      ->assertOk()
      ->assertJsonFragment(['id' => $order->id]);
  });

  it('customer can create a new order', function () {
    $payload = [
      'items' => [
        ['product_id' => $this->product->id, 'quantity' => 2],
      ],
    ];
    $this->actingAs($this->user, 'api')
      ->postJson('/api/orders', $payload)
      ->assertCreated()
      ->assertJsonFragment(['status' => 'pending']);
  });

  it('order cannot be created if stock is insufficient', function () {
    $payload = [
      'items' => [
        ['product_id' => $this->product->id, 'quantity' => 999],
      ],
    ];
    $this->actingAs($this->user, 'api')
      ->postJson('/api/orders', $payload)
      ->assertStatus(422)
      ->assertJsonStructure(['message']);
  });

  it('customer cannot see another user\'s order', function () {
    $otherUser = User::factory()->create();
    $order = Order::factory()->create(['user_id' => $otherUser->id]);
    $this->actingAs($this->user, 'api')
      ->getJson('/api/orders/' . $order->id)
      ->assertStatus(404);
  });

  it('admin can see any order', function () {
    $order = Order::factory()->create();
    $this->actingAs($this->admin, 'api')
      ->getJson('/api/orders/' . $order->id)
      ->assertOk()
      ->assertJsonFragment(['id' => $order->id]);
  });
});
