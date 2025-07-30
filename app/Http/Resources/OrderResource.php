<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param Request $request
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'user_id' => $this->user_id,
      'status' => $this->status,
      'total_price' => $this->total_price,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
      'products' => $this->whenLoaded('products', function () {
        return $this->products->map(function ($product) {
          return [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'price' => $product->price,
            'stock_quantity' => $product->stock_quantity,
            'items' => [
              'quantity' => $product->pivot->quantity,
              'unit_price' => $product->pivot->unit_price,
            ],
          ];
        });
      }),
    ];
  }
}

