<?php

namespace App\Http\Middleware;

use EnumRoleUser;

class AdminClinicalReceptionAllowedMiddleware extends RoleUserMiddleware
{
    protected array $roles = [
        EnumRoleUser::ADMIN->value,
        EnumRoleUser::CLINICAL->value,
        EnumRoleUser::RECEPTION->value,
    ];
}
