<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Contact;
use App\Models\Patient;
use App\Models\Caregiver;
use App\Models\User;
use App\Models\Appointment;
use App\Observers\AuditLogObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Contact::observe(AuditLogObserver::class);
        Patient::observe(AuditLogObserver::class);
    Caregiver::observe(AuditLogObserver::class);
    Appointment::observe(AuditLogObserver::class);
        User::observe(AuditLogObserver::class);
    }
}
