<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    public function allByVendor(int $vendorId): Collection
    {
        return Order::with('items.product', 'user')
            ->where('vendor_id', $vendorId)
            ->latest()
            ->get();
    }

    public function allByUser(int $userId): Collection
    {
        return Order::with('items.product', 'vendor')
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function findById(int $id): ?Order
    {
        return Order::with('items.product', 'vendor', 'user')->find($id);
    }

    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function updateStatus(Order $order, int $status): Order
    {
        $order->update(['status' => $status]);

        return $order->fresh();
    }

    public function updatePaymentStatus(Order $order, int $status): Order
    {
        $order->update(['payment_status' => $status]);

        return $order->fresh();
    }
}