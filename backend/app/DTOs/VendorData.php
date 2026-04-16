<?php

namespace App\DTOs;

class VendorData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $description = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name:        $data['name'],
            email:       $data['email'],
            description: $data['description'] ?? null,
        );
    }
}