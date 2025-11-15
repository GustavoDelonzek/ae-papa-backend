<?php

namespace App\Http\Middleware;

use EnumRoleUser;

class AdminAllowedMiddleware
{
    protected array $roles = [
        EnumRoleUser::ADMIN->value,
    ];
}
