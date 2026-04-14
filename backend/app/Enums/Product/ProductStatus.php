<?php

namespace App\Enums\Product;

enum ProductStatus: int
{
    case ACTIVE   = 1;
    case INACTIVE = 2;

    public static function values(): array
    {
        return array_map(
            static fn(self $item) => $item->value,
            self::cases()
        );
    }
}