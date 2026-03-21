<?php

namespace App\Enums;

enum EnumRoleUser: string
{
    case ADMIN = 'admin';
    case CLINICAL = 'clinical';

    public static function values(): array
    {
        return [
            self::ADMIN->value,
            self::CLINICAL->value,
        ];
    }

    public static function isValidRole(string $role): bool
    {
        return in_array($role, self::values());
    }
}
