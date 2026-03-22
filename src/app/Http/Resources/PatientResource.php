<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'cpf' => $this->cpf,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'marital_status' => $this->marital_status,
            'profile_picture_url' => $this->profile_picture_url,
            'caregivers' => $this->whenLoaded('caregivers', function () {
                return $this->caregivers;
            }),
            'socioeconomic_profile' => $this->whenLoaded('socioeconomicProfile', function () {
                return $this->socioeconomicProfile;
            }),
            'clinical_record' => $this->whenLoaded('clinicalRecord', function () {
                return $this->clinicalRecord;
            }),
            'addresses' => $this->whenLoaded('addresses', function () {
                return $this->addresses;
            }),
            'contacts' => $this->whenLoaded('contacts', function () {
                return $this->contacts;
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
