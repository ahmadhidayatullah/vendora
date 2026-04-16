<?php

namespace App\Repositories;

use App\Models\Vendor;
use App\Repositories\Contracts\VendorRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class VendorRepository implements VendorRepositoryInterface
{
    public function all(): Collection
    {
        return Vendor::with('user')->get();
    }

    public function findById(int $id): ?Vendor
    {
        return Vendor::find($id);
    }

    public function findByUserId(int $userId): ?Vendor
    {
        return Vendor::where('user_id', $userId)->first();
    }

    public function create(array $data): Vendor
    {
        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(6);

        return Vendor::create($data);
    }

    public function update(Vendor $vendor, array $data): Vendor
    {
        $vendor->update($data);

        return $vendor->fresh();
    }

    public function delete(Vendor $vendor): void
    {
        $vendor->delete();
    }
}