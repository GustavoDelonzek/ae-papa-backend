<?php

namespace App\Http\Services;

use App\Filters\CaregiverFilter;
use App\Models\Caregiver;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Collection;

readonly class CaregiverService
{
    public function getAllCaregivers(array $filters = []): Collection
    {
        $caregiversBuilder = (new CaregiverFilter($filters, Caregiver::query()))->applyFilters();

        return $caregiversBuilder->with('patients')->get();
    }

    public function storeCaregiver(array $data): Caregiver
    {
        $caregiver = Caregiver::create([
            'birth_date' => data_get($data, 'birth_date'),
            'full_name' => data_get($data, 'full_name'),
            'gender' => data_get($data, 'gender'),
            'cpf' => data_get($data, 'cpf'),
            'rg' => data_get($data, 'rg'),
            'education_level' => data_get($data, 'education_level'),
        ]);

        if ($patientId = data_get($data, 'patient_id')) {
            $caregiver->patients()->attach($patientId, [
                'kinship' => data_get($data, 'kinship'),
            ]);
        }

        return $caregiver->load('patients');
    }

    public function updateCaregiver(Caregiver $caregiver, array $data): Caregiver
    {
        $caregiver->update($data);

        return $caregiver->load('patients');
    }

    public function attachPatient(Caregiver $caregiver, Patient $patient, string $kinship): Caregiver
    {
        if ($caregiver->patients()->where('patient_id', $patient->id)->exists()) {
            abort(409, 'Caregiver is already linked to this patient');
        }

        $caregiver->patients()->attach($patient->id, ['kinship' => $kinship]);

        return $caregiver->load('patients');
    }

    public function detachPatient(Caregiver $caregiver, Patient $patient): Caregiver
    {
        if (!$caregiver->patients()->where('patient_id', $patient->id)->exists()) {
            abort(404, 'Relationship not found');
        }

        $caregiver->patients()->detach($patient->id);

        return $caregiver->load('patients');
    }

    public function updatePatientRelationship(Caregiver $caregiver, Patient $patient, string $kinship): Caregiver
    {
        if (!$caregiver->patients()->where('patient_id', $patient->id)->exists()) {
            abort(404, 'Relationship not found');
        }

        $caregiver->patients()->updateExistingPivot($patient->id, ['kinship' => $kinship]);

        return $caregiver->load('patients');
    }
}
