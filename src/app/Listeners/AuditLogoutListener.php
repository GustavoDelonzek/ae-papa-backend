<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\AuditLog;

class AuditLogoutListener
{
    public function handle(Logout $event)
    {
        AuditLog::create([
            'user_name' => $event->user->name,
            'action' => 'logout',
            'model_type' => 'User',
            'model_id' => $event->user->id,
            'changes' => null,
        ]);
    }
}
