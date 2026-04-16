<?php

namespace App\Repositories\Contracts;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Collection;

interface VendorRepositoryInterface
{
    public function all(): Collection;
    public function findById(int $id): ?Vendor;
    public function findByUserId(int $userId): ?Vendor;
    public function create(array $data): Vendor;
    public function update(Vendor $vendor, array $data): Vendor;
    public function delete(Vendor $vendor): void;
}