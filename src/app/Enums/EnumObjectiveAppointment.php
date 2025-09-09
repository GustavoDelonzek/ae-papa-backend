<?php

namespace App\Enums;

enum EnumObjectiveAppointment: string
{
    case DONATION = 'donation';
    case PROJECT = 'project';
    case TREATMENT = 'treatment';
    case RESEARCH = 'research';
    case OTHER = 'other';

    public static function values(): array
    {
        return [
            self::DONATION->value,
            self::PROJECT->value,
            self::TREATMENT->value,
            self::RESEARCH->value,
            self::OTHER->value,
        ];
    }
}
