<?php

namespace App\Http\Middleware;

use App\Enums\EnumRoleUser;

class AdminAllowedMiddleware extends RoleUserMiddleware
{
    protected array $roles = [
        EnumRoleUser::ADMIN->value,
    ];
}
