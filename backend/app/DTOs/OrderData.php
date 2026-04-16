<?php

namespace App\DTOs;

class OrderData
{
    public function __construct(
        public readonly int   $user_id,
        public readonly int   $vendor_id,
        public readonly array $items,  // [['product_id' => 1, 'quantity' => 2], ...]
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            user_id:   $data['user_id'],
            vendor_id: $data['vendor_id'],
            items:     $data['items'],
        );
    }
}