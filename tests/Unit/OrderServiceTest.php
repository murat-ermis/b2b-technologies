<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

describe('OrderService', function () {
  beforeEach(function () {
    $this->user = User::factory()->create(['role' => 'customer']);
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->product = Product::factory()->create(['stock_quantity' => 10, 'price' => 100]);
    $this->service = app(OrderService::class);
  });

  it('can create order with valid stock', function () {
    $data = [
      'user_id' => $this->user->id,
      'items' => [
        ['product_id' => $this->product->id, 'quantity' => 2],
      ],
    ];
    $order = $this->service->create($data);
    expect($order)->not()->toBeNull()
      ->and($order->status)->toBe('pending')
      ->and($order->total_price)->toEqual(200)
      ->and($order->products->first()->pivot->quantity)->toBe(2)
      ->and($order->products->first()->pivot->unit_price)->toEqual(100);
  });

  it('throws error if stock is insufficient', function () {
    $data = [
      'user_id' => $this->user->id,
      'items' => [
        ['product_id' => $this->product->id, 'quantity' => 999],
      ],
    ];
    $this->expectException(ValidationException::class);
    $this->service->create($data);
  });

  it('decreases product stock after order', function () {
    $data = [
      'user_id' => $this->user->id,
      'items' => [
        ['product_id' => $this->product->id, 'quantity' => 3],
      ],
    ];
    $this->service->create($data);
    $this->product->refresh();
    expect($this->product->stock_quantity)->toBe(7);
  });

  it('returns only user orders for customer', function () {
    Order::factory()->create(['user_id' => $this->user->id]);
    Order::factory()->create(['user_id' => $this->admin->id]);
    $orders = $this->service->allForUser($this->user);
    expect($orders->pluck('user_id')->unique())->toEqual(collect([$this->user->id]));
  });

  it('returns all orders for admin', function () {
    Order::factory()->create(['user_id' => $this->user->id]);
    Order::factory()->create(['user_id' => $this->admin->id]);
    $orders = $this->service->allForUser($this->admin);
    expect($orders->count())->toBeGreaterThanOrEqual(2);
  });
});
