<?php

namespace App\Enums\User;

enum UserRole: string
{
    case ADMIN    = 'admin';
    case VENDOR   = 'vendor';
    case CUSTOMER = 'customer';

    public static function values(): array
    {
        return array_map(
            static fn(self $item) => $item->value,
            self::cases()
        );
    }
}