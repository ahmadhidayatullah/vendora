<?php

namespace App\DTOs;

class ProductData
{
    public function __construct(
        public readonly int $vendor_id,
        public readonly string $name,
        public readonly float $price,
        public readonly int $stock,
        public readonly ?string $description = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            vendor_id:   $data['vendor_id'],
            name:        $data['name'],
            price:       $data['price'],
            stock:       $data['stock'],
            description: $data['description'] ?? null,
        );
    }
}