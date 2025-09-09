<?php

namespace App\Enums;

enum EnumGenderPerson: string
{
    case MALE = 'M';
    case FEMALE = 'F';

    public static function values(): array
    {
        return [
            self::MALE->value,
            self::FEMALE->value,
        ];
    }
}
