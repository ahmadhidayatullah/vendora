<?php

namespace App\Services;

use App\DTOs\OrderData;
use App\Enums\Order\OrderStatus;
use App\Enums\Order\PaymentStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderService
{
    public function __construct(
        private readonly OrderRepositoryInterface   $orderRepository,
        private readonly ProductRepositoryInterface $productRepository,
    ) {}

    public function allByVendor(int $vendorId): Collection
    {
        return $this->orderRepository->allByVendor($vendorId);
    }

    public function allByUser(int $userId): Collection
    {
        return $this->orderRepository->allByUser($userId);
    }

    public function findById(int $id): ?Order
    {
        return $this->orderRepository->findById($id);
    }

    public function create(OrderData $dto): Order
    {
        // 1. Validate stock & calculate total
        $total = 0;
        $resolvedItems = [];

        foreach ($dto->items as $item) {
            $product = $this->productRepository->findById($item['product_id']);

            if (!$product || !$product->isInStock()) {
                throw ValidationException::withMessages([
                    'items' => "Product [{$item['product_id']}] is out of stock.",
                ]);
            }

            if ($product->stock < $item['quantity']) {
                throw ValidationException::withMessages([
                    'items' => "Insufficient stock for product [{$product->name}].",
                ]);
            }

            $subtotal        = $product->price * $item['quantity'];
            $total          += $subtotal;
            $resolvedItems[] = [
                'product_id' => $product->id,
                'quantity'   => $item['quantity'],
                'unit_price' => $product->price,
                'subtotal'   => $subtotal,
            ];
        }

        // 2. Create the order
        $order = $this->orderRepository->create([
            'user_id'        => $dto->user_id,
            'vendor_id'      => $dto->vendor_id,
            'order_number'   => 'ORD-' . strtoupper(Str::random(8)),
            'status'         => OrderStatus::PENDING,
            'payment_status' => PaymentStatus::UNPAID,
            'total_amount'   => $total,
        ]);

        // 3. Create order items & decrement stock
        foreach ($resolvedItems as $item) {
            OrderItem::create(array_merge($item, ['order_id' => $order->id]));

            $product = $this->productRepository->findById($item['product_id']);
            $this->productRepository->decrementStock($product, $item['quantity']);
        }

        return $order->load('items.product');
    }

    public function updateStatus(Order $order, OrderStatus $status): Order
    {
        return $this->orderRepository->updateStatus($order, $status->value);
    }

    public function updatePaymentStatus(Order $order, PaymentStatus $status): Order
    {
        return $this->orderRepository->updatePaymentStatus($order, $status->value);
    }
}