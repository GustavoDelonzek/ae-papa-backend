<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuditLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'user_name'  => $this->user_name,
            'action'     => $this->action,
            'model_type' => $this->model_type,
            'model_id'   => $this->model_id,
            'changes'    => json_decode($this->changes, true),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
