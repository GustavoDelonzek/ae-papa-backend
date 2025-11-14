<?php

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use App\Listeners\AuditLoginListener;
use App\Listeners\AuditLogoutListener;
use App\Listeners\AuditFailedLoginListener;

class EventServiceProvider
{
    protected $listen = [
        Login::class => [
            AuditLoginListener::class,
        ],
        Logout::class => [
            AuditLogoutListener::class,
        ],
        Failed::class => [
            AuditFailedLoginListener::class,
        ],
    ];
}

