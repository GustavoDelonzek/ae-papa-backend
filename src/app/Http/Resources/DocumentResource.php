<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
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
            'patient_id' => $this->patient_id,
            'caregiver_id' => $this->caregiver_id,
            'user_id' => $this->user_id,
            'appointment_id' => $this->appointment_id,
            'file_name' => $this->file_name,
            'file_path' => $this->file_path,
            'document_type' => $this->document_type,
            'mime_type' => $this->mime_type,
            'description' => $this->description,
            'status' => $this->status,
            'public_url' => $this->public_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => UserResource::make($this->whenLoaded('user')),
            'patient' => PatientResource::make($this->whenLoaded('patient')),
            'caregiver' => CaregiverResource::make($this->whenLoaded('caregiver')),
        ];
    }
}
