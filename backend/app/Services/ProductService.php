<?php

namespace App\Services;

use App\DTOs\ProductData;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
    ) {}

    public function allByVendor(int $vendorId): Collection
    {
        return $this->productRepository->allByVendor($vendorId);
    }

    public function findById(int $id): ?Product
    {
        return $this->productRepository->findById($id);
    }

    public function create(ProductData $dto): Product
    {
        return $this->productRepository->create([
            'vendor_id'   => $dto->vendor_id,
            'name'        => $dto->name,
            'price'       => $dto->price,
            'stock'       => $dto->stock,
            'description' => $dto->description,
        ]);
    }

    public function update(Product $product, ProductData $dto): Product
    {
        return $this->productRepository->update($product, [
            'name'        => $dto->name,
            'price'       => $dto->price,
            'stock'       => $dto->stock,
            'description' => $dto->description,
        ]);
    }

    public function delete(Product $product): void
    {
        $this->productRepository->delete($product);
    }
}