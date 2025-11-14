<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use App\Models\AuditLog;
use App\Enums\EnumActionAuditLogs;
use Illuminate\Support\Facades\Request;

class AuditFailedLoginListener
{
    public function handle(Failed $event)
    {
        $ip = Request::ip();
        $userAgent = Request::header('User-Agent');

        // $event->credentials may contain identifiers (email, username) but not password in plain
        $identifier = $event->credentials['email'] ?? ($event->credentials['username'] ?? null);

        AuditLog::create([
            'user_name' => $identifier,
            'action' => EnumActionAuditLogs::USER_LOGIN_FAILED->value,
            'model_type' => 'User',
            'model_id' => null,
            'changes' => [
                'ip' => $ip,
                'user_agent' => $userAgent,
                'credentials' => $identifier ? ['identifier' => $identifier] : null,
            ],
        ]);
    }
}
