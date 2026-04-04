<?php

namespace App\Enums;

enum EnumObjectiveAppointment: string
{
    case DONATION = 'donation';
    case PROJECT = 'project';
    case TREATMENT = 'treatment';
    case RESEARCH = 'research';
    case VISIT = 'visit';
    case MESA_BRASIL = 'mesa_brasil';
    case SOCIAL_ASSISTANCE = 'social_assistance';
    case OTHER = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::DONATION => 'Doação',
            self::PROJECT => 'Projeto',
            self::TREATMENT => 'Tratamento',
            self::RESEARCH => 'Pesquisa',
            self::VISIT => 'Visita',
            self::MESA_BRASIL => 'Mesa Brasil',
            self::SOCIAL_ASSISTANCE => 'Sócio Assistencial',
            self::OTHER => 'Outro',
        };
    }

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public static function fromValue(string $value): string
    {
        $case = self::tryFrom($value);
        return $case ? $case->getLabel() : $value;
    }
}
