<?php

namespace App\Http\Services;

use App\Models\Caregiver;
use Illuminate\Database\Eloquent\Collection;

readonly class CaregiverService
{
    public function getAllCaregiversByPatient(array $data): Collection
    {
        return Caregiver::where('patient_id', data_get($data, 'patient_id'))->get();
    }

    public function storeCaregiver(array $data): Caregiver
    {
        return Caregiver::create([
            'patient_id' => data_get($data, 'patient_id'),
            'birth_date' => data_get($data, 'birth_date'),
            'full_name' => data_get($data, 'full_name'),
            'relationship' => data_get($data, 'relationship'),
            'gender' => data_get($data, 'gender'),
            'marital_status' => data_get($data, 'marital_status'),
            'cpf' => data_get($data, 'cpf'),
            'rg' => data_get($data, 'rg'),
        ]);
    }

    public function getAnCaregiverByPatient(array $data, Caregiver $caregiver): Caregiver
    {
        if ($caregiver->patient_id !== data_get($data, 'patient_id')) {
            abort(404);
        }

        return $caregiver;
    }

    public function updateCaregiver(Caregiver $caregiver, array $data): Caregiver
    {
        if (data_get($data, 'patient_id') !== $caregiver->patient_id) {
            abort(404);
        }

        $caregiver->update($data);

        return $caregiver;
    }
}
