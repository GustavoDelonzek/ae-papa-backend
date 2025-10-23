<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'id' => $this->id,
        'owner_id' => $this->owner_id,
        'owner_type' => $this->owner_type,
        'type' => $this->type,
        'value' => $this->value,
        'is_primary' => $this->is_primary,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
        'audit_logs' => AuditLogResource::collection($this->whenLoaded('auditLogs')),
    ];
    }
}
