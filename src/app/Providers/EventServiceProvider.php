<?php

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Listeners\AuditLoginListener;
use App\Listeners\AuditLogoutListener;

class EventServiceProvider
{
    protected $listen = [
        Login::class => [
            AuditLoginListener::class,
        ],
        Logout::class => [
            AuditLogoutListener::class,
        ],
    ];
}

