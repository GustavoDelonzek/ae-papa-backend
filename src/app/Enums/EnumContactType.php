<?php

namespace App\Enums;

enum EnumContactType: string
{
    case EMAIL = 'email';
    case PHONE = 'phone';
    case WHATSAPP = 'whatsapp';
    

    public static function values(): array
    {
        return [
            self::EMAIL->value,
            self::PHONE->value,
            self::WHATSAPP->value,
        ];
    }
}
