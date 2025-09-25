<?php

namespace App\Http\Services;

use App\Filters\PatientFilter;
use App\Models\Patient;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class PatientService
{
    public function showAllPatients(array $filters): LengthAwarePaginator
    {
        $patientsBuilder = (new PatientFilter($filters, Patient::query()))->applyFilters();

        return $patientsBuilder->paginate(data_get($filters, 'per_page', 15));
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
