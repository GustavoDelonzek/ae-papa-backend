<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\AuditLog;
use App\Enums\EnumActionAuditLogs;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class AuditLoginListener
{
    public function handle(Login $event)
    {
        // gather request/session context (may be null in some contexts)
        $ip = Request::ip();
        $userAgent = Request::header('User-Agent');
        $sessionId = Session::getId();
        $remember = property_exists($event, 'remember') ? $event->remember : null;

        AuditLog::create([
            'user_name' => $event->user->name ?? null,
            'action' => EnumActionAuditLogs::USER_LOGIN->value,
            'model_type' => 'User',
            'model_id' => $event->user->id ?? null,
            'changes' => [
                'ip' => $ip,
                'user_agent' => $userAgent,
                'session_id' => $sessionId,
                'remember' => $remember,
            ],
        ]);
    }
}
