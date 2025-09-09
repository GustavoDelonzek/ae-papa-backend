<?php

namespace App\Enums;

enum EnumRelationshipCaregivers: string
{
    case SON = 'son';
    case DAUGHTER = 'daughter';
    case SPOUSE = 'spouse';
    case PARTNER = 'partner';
    case FATHER = 'father';
    case MOTHER = 'mother';
    case BROTHER = 'brother';
    case SISTER = 'sister';
    case GRAND_SON = 'grand_son';
    case GRAND_DAUGHTER = 'grand_daughter';
    case NEPHEW = 'nephew';
    case NIECE = 'niece';
    case FRIEND = 'friend';
    case PROFESSIONAL_CAREGIVER = 'professional_caregiver';
    case OTHER = 'other';

    public static function values(): array
    {
        return [
            self::SON->value,
            self::DAUGHTER->value,
            self::SPOUSE->value,
            self::PARTNER->value,
            self::FATHER->value,
            self::MOTHER->value,
            self::BROTHER->value,
            self::SISTER->value,
            self::GRAND_SON->value,
            self::GRAND_DAUGHTER->value,
            self::NEPHEW->value,
            self::NIECE->value,
            self::FRIEND->value,
            self::PROFESSIONAL_CAREGIVER->value,
            self::OTHER->value,
        ];
    }
}
