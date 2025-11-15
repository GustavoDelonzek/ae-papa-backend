<?php

enum EnumRoleUser: string
{
    case ADMIN = 'admin';
    case CLINICAL = 'clinical';
    case RECEPTION = 'reception';

    public static function values(): array
    {
        return [
            self::ADMIN->value,
            self::CLINICAL->value,
            self::RECEPTION->value,
        ];
    }

    public static function isValidRole(string $role): bool
    {
        return in_array($role, self::values());
    }
}
