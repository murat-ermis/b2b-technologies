<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductService
{
  protected ProductRepository $productRepository;

  public function __construct(ProductRepository $repository)
  {
    $this->productRepository = $repository;
  }

  public function findOrFail(int $id): Product
  {
    return $this->productRepository->findOrFail($id);
  }

  public function list(): Collection
  {
    return $this->productRepository->all();
  }

  public function create(array $data): Product
  {
    return $this->productRepository->create($data);
  }

  public function update(Product $product, array $data): Product
  {
    return $this->productRepository->update($product, $data);
  }

  public function delete(Product $product): void
  {
    $product->delete();
  }
}

