<?php

namespace App\Enums\Order;

enum OrderStatus: int
{
    case PENDING    = 1;
    case PROCESSING = 2;
    case COMPLETED  = 3;
    case CANCELLED  = 4;

    public static function values(): array
    {
        return array_map(
            static fn(self $item) => $item->value,
            self::cases()
        );
    }
}