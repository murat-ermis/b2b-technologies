<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
  protected ProductService $productService;

  public function __construct(ProductService $service)
  {
    $this->productService = $service;
  }

  public function index(): JsonResponse
  {
    $result = $this->productService->list();
    return response()->json(ProductResource::collection($result));
  }

  public function store(StoreRequest $request): JsonResponse
  {
    $result = $this->productService->create($request->validated());
    return response()->json(new ProductResource($result), 201);
  }

  public function update(Product $product, UpdateRequest $request): JsonResponse
  {
    $result = $this->productService->update($product, $request->validated());
    return response()->json(new ProductResource($result));
  }

  public function destroy(Product $product): JsonResponse
  {
    $this->productService->delete($product);
    return response()->json(['message' => 'Product deleted']);
  }
}
