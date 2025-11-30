<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use App\Listeners\AuditLoginListener;
use App\Listeners\AuditLogoutListener;
use App\Listeners\AuditFailedLoginListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
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

