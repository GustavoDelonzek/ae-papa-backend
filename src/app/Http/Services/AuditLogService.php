<?php

namespace App\Http\Services;

use App\Models\AuditLog;

class AuditLogService
{
    public function showAllLogs(array $filters = [])
    {
        return AuditLog::latest()->paginate(20);
    }

    public function storeLog(array $data): AuditLog
    {
        return AuditLog::create($data);
    }

    public function updateLog(AuditLog $log, array $data): AuditLog
    {
        $log->update($data);
        return $log;
    }

    public function deleteLog(AuditLog $log): void
    {
        $log->delete();
    }
}
