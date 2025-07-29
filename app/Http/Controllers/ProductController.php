<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
  protected ProductService $productService;

  public function __construct(ProductService $service)
  {
    $this->productService = $service;
  }

  public function index(): JsonResponse
  {
    if (!Gate::allows('view', Product::class)) {
      abort(403);
    }
    $result = $this->productService->list();
    return response()->json(ProductResource::collection($result));
  }

  public function store(StoreRequest $request): JsonResponse
  {
    if (!Gate::allows('create', Product::class)) {
      abort(403);
    }
    $result = $this->productService->create($request->validated());
    return response()->json(new ProductResource($result), 201);
  }

  public function update(int $id, UpdateRequest $request): JsonResponse
  {
    $product = $this->productService->findOrFail($id);

    if (!Gate::allows('update', $product)) {
      abort(403);
    }

    $result = $this->productService->update($product, $request->validated());
    return response()->json(new ProductResource($result));
  }

  public function destroy(int $id): JsonResponse
  {
    $product = $this->productService->findOrFail($id);

    if (!Gate::allows('delete', $product)) {
      abort(403);
    }
    $this->productService->delete($product);
    return response()->json(['message' => 'Product deleted']);
  }
}
