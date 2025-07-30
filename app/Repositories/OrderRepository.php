<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Product;
use App\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
  public function create(array $data)
  {
    return DB::transaction(function () use ($data) {
      $order = Order::create([
        'user_id' => $data['user_id'] ?? auth()->user()?->id,
        'status' => 'pending',
        'total_price' => 0,
      ]);

      $total = 0;
      $pivotData = [];
      $now = now();
      foreach ($data['items'] as $item) {
        $product = Product::findOrFail($item['product_id']);
        $unitPrice = $product->price;
        $quantity = $item['quantity'];
        $total += $unitPrice * $quantity;
        $pivotData[$product->id] = [
          'quantity' => $quantity,
          'unit_price' => $unitPrice,
          'created_at' => $now,
          'updated_at' => $now,
        ];
        $product->decrement('stock_quantity', $quantity);
      }
      $order->products()->attach($pivotData);
      $order->total_price = $total;
      $order->save();
      return $order->load(['products' => function($q) {
        $q->withPivot(['quantity', 'unit_price', 'created_at', 'updated_at']);
      }]);
    });
  }

  public function allForUser($user): Collection
  {
    if ($user->role === Role::Admin->value) {
      return Order::with('products')->get();
    }
    return Order::with('products')->where('user_id', $user->id)->get();
  }

  public function findForUser($id, $user)
  {
    $query = Order::with('products')->where('id', $id);
    if ($user->role !== Role::Admin->value) {
      $query->where('user_id', $user->id);
    }
    return $query->firstOrFail();
  }
}
