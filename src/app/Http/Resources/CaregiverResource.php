<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CaregiverResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'cpf' => $this->cpf,
            'rg' => $this->rg,
            'education_level' => $this->education_level,
            'patients' => $this->whenLoaded('patients', function () {
                return $this->patients->map(fn ($patient) => [
                    'id' => $patient->id,
                    'full_name' => $patient->full_name,
                    'kinship' => $patient->pivot->kinship,
                ]);
            }),
            'contacts' => $this->whenLoaded('contacts'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
