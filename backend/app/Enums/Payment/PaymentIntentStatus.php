<?php

namespace App\Enums\Payment;

enum PaymentIntentStatus: int
{
    case PENDING    = 1;
    case PROCESSING = 2;
    case SUCCEEDED  = 3;
    case FAILED     = 4;

    public static function values(): array
    {
        return array_map(
            static fn(self $item) => $item->value,
            self::cases()
        );
    }
}