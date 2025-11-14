<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\AuditLog;
use App\Enums\EnumActionAuditLogs;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class AuditLogoutListener
{
    public function handle(Logout $event)
    {
        $ip = Request::ip();
        $userAgent = Request::header('User-Agent');
        $sessionId = Session::getId();

        AuditLog::create([
            'user_name' => $event->user->name ?? null,
            'action' => EnumActionAuditLogs::USER_LOGOUT->value,
            'model_type' => 'User',
            'model_id' => $event->user->id ?? null,
            'changes' => [
                'ip' => $ip,
                'user_agent' => $userAgent,
                'session_id' => $sessionId,
            ],
        ]);
    }
}
