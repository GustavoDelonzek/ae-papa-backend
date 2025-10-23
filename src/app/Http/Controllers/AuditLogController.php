<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuditLogResource;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Listar todos os logs, com possibilidade de filtro por modelo ou usuário
     */
    public function index(Request $request)
    {
        $query = AuditLog::query();

        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        if ($request->filled('model_id')) {
            $query->where('model_id', $request->model_id);
        }

        if ($request->filled('user_name')) {
            $query->where('user_name', $request->user_name);
        }

        $logs = $query->orderBy('created_at', 'desc')->get();

        return AuditLogResource::collection($logs);
    }

    /**
     * Exibir um log específico
     */
    public function show(AuditLog $auditLog)
    {
        return AuditLogResource::make($auditLog);
    }
}
