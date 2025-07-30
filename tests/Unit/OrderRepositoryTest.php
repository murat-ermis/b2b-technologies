<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repositories\OrderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('OrderRepository', function () {
    beforeEach(function () {
        $this->user = User::factory()->create(['role' => 'customer']);
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->product = Product::factory()->create(['stock_quantity' => 10, 'price' => 100]);
        $this->repo = app(OrderRepository::class);
    });

    it('can create an order with products', function () {
        $data = [
            'user_id' => $this->user->id,
            'items' => [
                ['product_id' => $this->product->id, 'quantity' => 2],
            ],
        ];
        $order = $this->repo->create($data);
        expect($order)->not()->toBeNull()
          ->and($order->user_id)->toBe($this->user->id)
          ->and($order->products->first()->pivot->quantity)->toBe(2);
    });

    it('can list all orders for admin', function () {
        Order::factory()->create(['user_id' => $this->user->id]);
        Order::factory()->create(['user_id' => $this->admin->id]);
        $orders = $this->repo->allForUser($this->admin);
        expect($orders->count())->toBeGreaterThanOrEqual(2);
    });

    it('can list only user orders for customer', function () {
        Order::factory()->create(['user_id' => $this->user->id]);
        Order::factory()->create(['user_id' => $this->admin->id]);
        $orders = $this->repo->allForUser($this->user);
        expect($orders->pluck('user_id')->unique())->toEqual(collect([$this->user->id]));
    });

    it('can find order for user', function () {
        $order = Order::factory()->create(['user_id' => $this->user->id]);
        $found = $this->repo->findForUser($order->id, $this->user);
        expect($found)->not()->toBeNull()
          ->and($found->id)->toBe($order->id);
    });
});

