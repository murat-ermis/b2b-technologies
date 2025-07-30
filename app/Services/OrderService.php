<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class OrderService
{
  protected OrderRepository $orderRepository;
  protected ProductRepository $productRepository;

  public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository)
  {
    $this->orderRepository = $orderRepository;
    $this->productRepository = $productRepository;
  }

  /**
   * @throws ValidationException
   */
  public function create(array $data)
  {
    $items = $data['items'] ?? [];
    if (empty($items)) {
      throw ValidationException::withMessages(['items' => 'En az bir ürün seçilmelidir.']);
    }
    foreach ($items as $item) {
      $product = $this->productRepository->findOrFail($item['product_id']);
      if ($product->stock_quantity < $item['quantity']) {
        throw ValidationException::withMessages([
          'items' => [
            "Ürün: {$product->name} (SKU: {$product->sku}) için istenen stok: {$item['quantity']}, mevcut stok: {$product->stock_quantity}."
          ]
        ]);
      }
    }
    return $this->orderRepository->create($data);
  }

  public function allForUser($user): Collection
  {
    return $this->orderRepository->allForUser($user);
  }

  public function findForUser($id, $user)
  {
    return $this->orderRepository->findForUser($id, $user);
  }
}
