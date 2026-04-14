<?php

namespace App\Enums\Order;

enum PaymentStatus: int
{
    case UNPAID   = 1;
    case PAID     = 2;
    case FAILED   = 3;
    case REFUNDED = 4;

    public static function values(): array
    {
        return array_map(
            static fn(self $item) => $item->value,
            self::cases()
        );
    }
}