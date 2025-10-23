<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\AuditLog;

class AuditLoginListener
{
    public function handle(Login $event)
    {
        AuditLog::create([
            'user_name' => $event->user->name,
            'action' => 'login',
            'model_type' => 'User',
            'model_id' => $event->user->id,
            'changes' => null,
        ]);
    }
}
