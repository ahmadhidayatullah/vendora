<?php

namespace App\Enums\Vendor;

enum VendorStatus: int
{
    case ACTIVE    = 1;
    case INACTIVE  = 2;
    case SUSPENDED = 3;

    public static function values(): array
    {
        return array_map(
            static fn(self $item) => $item->value,
            self::cases()
        );
    }
}