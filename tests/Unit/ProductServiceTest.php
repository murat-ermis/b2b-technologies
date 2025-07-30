<?php

use App\Models\Product;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('ProductService', function () {
  beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->customer = User::factory()->create(['role' => 'customer']);
    $this->service = app(ProductService::class);
    $this->product = Product::factory()->create([
      'name' => 'Test Product',
      'sku' => 'SKU-1234',
      'price' => 50,
      'stock_quantity' => 20,
    ]);
  });

  it('can list all products', function () {
    $products = $this->service->list();
    expect($products)->toHaveCount(1)
      ->and($products->first()->name)->toBe('Test Product');
  });

  it('can find a product by id', function () {
    $product = $this->service->findOrFail($this->product->id);
    expect($product)->not()->toBeNull()
      ->and($product->sku)->toBe('SKU-1234');
  });

  it('can create a product', function () {
    $data = [
      'name' => 'New Product',
      'sku' => 'SKU-NEW',
      'price' => 99.99,
      'stock_quantity' => 10,
    ];
    $product = $this->service->create($data);
    expect($product)->not()->toBeNull()
      ->and($product->name)->toBe('New Product')
      ->and($product->sku)->toBe('SKU-NEW');
  });

  it('can update a product', function () {
    $data = [
      'name' => 'Updated Product',
      'sku' => $this->product->sku,
      'price' => 150,
      'stock_quantity' => 5,
    ];
    $updated = $this->service->update($this->product, $data);
    expect($updated->name)->toBe('Updated Product')
      ->and($updated->price)->toEqual(150)
      ->and($updated->stock_quantity)->toEqual(5);
  });

  it('can delete a product', function () {
    $this->service->delete($this->product);
    $this->product->refresh();
    expect($this->product->deleted_at)->not()->toBeNull();
  });
});
