<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

describe('ProductController', function () {
  beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->customer = User::factory()->create(['role' => 'customer']);
    $this->product = Product::factory()->create();
  });

  it('admin can list all products', function () {
    $this->actingAs($this->admin, 'api')
      ->getJson('/api/products')
      ->assertOk()
      ->assertJsonFragment(['id' => $this->product->id]);
  });

  it('customer can list all products', function () {
    $this->actingAs($this->customer, 'api')
      ->getJson('/api/products')
      ->assertOk()
      ->assertJsonFragment(['id' => $this->product->id]);
  });

  it('admin can create a product', function () {
    $payload = [
      'name' => 'Test Product',
      'sku' => 'SKU-TEST-1',
      'price' => 99.99,
      'stock_quantity' => 50,
    ];
    $this->actingAs($this->admin, 'api')
      ->postJson('/api/products', $payload)
      ->assertCreated()
      ->assertJsonFragment(['name' => 'Test Product']);
  });

  it('customer cannot create a product', function () {
    $payload = [
      'name' => 'Test Product',
      'sku' => 'SKU-TEST-2',
      'price' => 99.99,
      'stock_quantity' => 50,
    ];
    $this->actingAs($this->customer, 'api')
      ->postJson('/api/products', $payload)
      ->assertStatus(403);
  });

  it('admin can update a product', function () {
    $payload = [
      'name' => 'Updated Product',
      'sku' => $this->product->sku,
      'price' => 199.99,
      'stock_quantity' => 25,
    ];
    $this->actingAs($this->admin, 'api')
      ->putJson('/api/products/' . $this->product->id, $payload)
      ->assertOk()
      ->assertJsonFragment(['name' => 'Updated Product']);
  });

  it('customer cannot update a product', function () {
    $payload = [
      'name' => 'Updated Product',
      'sku' => $this->product->sku,
      'price' => 199.99,
      'stock_quantity' => 25,
    ];
    $this->actingAs($this->customer, 'api')
      ->putJson('/api/products/' . $this->product->id, $payload)
      ->assertStatus(403);
  });

  it('admin can delete a product', function () {
    $this->actingAs($this->admin, 'api')
      ->deleteJson('/api/products/' . $this->product->id)
      ->assertOk();
    $this->assertSoftDeleted('products', ['id' => $this->product->id]);
  });

  it('customer cannot delete a product', function () {
    $this->actingAs($this->customer, 'api')
      ->deleteJson('/api/products/' . $this->product->id)
      ->assertStatus(403);
  });
});
