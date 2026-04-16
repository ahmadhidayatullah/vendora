<?php

namespace App\Services;

use App\DTOs\VendorData;
use App\Enums\User\UserRole;
use App\Models\Vendor;
use App\Repositories\Contracts\VendorRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class VendorService
{
    public function __construct(
        private readonly VendorRepositoryInterface $vendorRepository,
    ) {}

    public function all(): Collection
    {
        return $this->vendorRepository->all();
    }

    public function findById(int $id): ?Vendor
    {
        return $this->vendorRepository->findById($id);
    }

    public function create(VendorData $dto, int $userId): Vendor
    {
        return $this->vendorRepository->create([
            'user_id'     => $userId,
            'name'        => $dto->name,
            'email'       => $dto->email,
            'description' => $dto->description,
        ]);
    }

    public function update(Vendor $vendor, VendorData $dto): Vendor
    {
        return $this->vendorRepository->update($vendor, [
            'name'        => $dto->name,
            'email'       => $dto->email,
            'description' => $dto->description,
        ]);
    }

    public function delete(Vendor $vendor): void
    {
        $this->vendorRepository->delete($vendor);
    }
}