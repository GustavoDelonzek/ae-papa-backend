<?php

namespace App\Enums;

enum EnumTypeDonation: string
{
    case FOOD_BASKET = 'food_basket';
    case MESA_BRASIL = 'mesa_brasil';
    case ADULT_DIAPER = 'adult_diaper';
    case SUPPLEMENT = 'supplement';
    case OTHER = 'other';

    public static function values(): array
    {
        return [
            self::FOOD_BASKET->value,
            self::MESA_BRASIL->value,
            self::ADULT_DIAPER->value,
            self::SUPPLEMENT->value,
            self::OTHER->value,
        ];
    }
}
