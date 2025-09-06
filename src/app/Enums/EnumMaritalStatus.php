<?php

namespace App\Enums;

enum EnumMaritalStatus: string
{
    case SINGLE = 'single';
    case MARRIED = 'married';
    case DIVORCED = 'divorced';
    case WIDOWED = 'widowed';

    public static function values(): array
    {
        return [
            self::SINGLE->value,
            self::MARRIED->value,
            self::DIVORCED->value,
            self::WIDOWED->value,
        ];
    }
}
