<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
  protected OrderService $orderService;

  public function __construct(OrderService $orderService)
  {
    $this->orderService = $orderService;
  }

  public function index(): JsonResponse
  {
    $orders = $this->orderService->allForUser(Auth::user());
    return response()->json(OrderResource::collection($orders));
  }

  public function show($id): JsonResponse
  {
    $order = $this->orderService->findForUser($id, Auth::user());
    return response()->json(new OrderResource($order));
  }

  /**
   * @throws ValidationException
   */
  public function store(StoreRequest $request): JsonResponse
  {
    $order = $this->orderService->create($request->validated());
    return response()->json(new OrderResource($order), 201);
  }
}
