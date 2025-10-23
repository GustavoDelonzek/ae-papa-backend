<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    protected $fillable = [
        'user_name',
        'action',
        'model_type',
        'model_id',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];
}
