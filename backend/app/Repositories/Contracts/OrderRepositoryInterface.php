<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface
{
    public function allByVendor(int $vendorId): Collection;
    public function allByUser(int $userId): Collection;
    public function findById(int $id): ?Order;
    public function create(array $data): Order;
    public function updateStatus(Order $order, int $status): Order;
    public function updatePaymentStatus(Order $order, int $status): Order;
}