<?php

namespace App\Http\Middleware;

use App\Enums\EnumRoleUser;

class AdminClinicalAllowedMiddleware extends RoleUserMiddleware
{
    protected array $roles = [
        EnumRoleUser::ADMIN->value,
        EnumRoleUser::CLINICAL->value,
    ];
}
