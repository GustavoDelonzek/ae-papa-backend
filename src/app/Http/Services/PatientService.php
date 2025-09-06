<?php

namespace App\Http\Services;

use App\Filters\PatientFilter;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Collection;

readonly class PatientService
{
    public function showAllPatients(array $filters): Collection
    {
        return (new PatientFilter($filters, Patient::query()))->applyFilters();
    }

    public function storePatient(array $data): Patient
    {
        return Patient::create($data);
    }

    public function updatePatient(Patient $patient, array $data): Patient
    {
        $patient->update($data);

        return $patient;
    }

    public function deletePatient(Patient $patient): void
    {
        $patient->delete();
    }

}
