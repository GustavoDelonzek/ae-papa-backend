<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
        'full_name' => $this->full_name,
        'birth_date' => $this->birth_date,
        'gender' => $this->gender,
        'cpf' => $this->cpf,
        'rg' => $this->rg,
        'marital_status' => $this->marital_status,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
        'audit_logs' => AuditLogResource::collection($this->whenLoaded('auditLogs')),
    ];
    }
}
