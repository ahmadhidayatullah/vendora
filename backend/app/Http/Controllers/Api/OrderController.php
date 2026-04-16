<?php

namespace App\Http\Controllers\Api;

use App\DTOs\OrderData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $orders = $request->user()->hasRole('vendor')
            ? $this->orderService->allByVendor($request->user()->vendor->id)
            : $this->orderService->allByUser($request->user()->id);

        return OrderResource::collection($orders);
    }

    public function show(int $id): OrderResource|JsonResponse
    {
        $order = $this->orderService->findById($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        return new OrderResource($order);
    }

    public function store(StoreOrderRequest $request): OrderResource|JsonResponse
    {
        try {
            $order = $this->orderService->create(
                OrderData::fromArray(array_merge(
                    $request->validated(),
                    ['user_id' => $request->user()->id]
                ))
            );

            return new OrderResource($order);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}