<?php

namespace App\Http\Services;

use App\Filters\PatientFilter;
use App\Jobs\UploadProfilePictureToGcp;
use App\Models\Patient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

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

    public function uploadProfilePicture(Patient $patient, $file): Patient
    {
        $extension = $file->getClientOriginalExtension();
        $safeFileName = 'profile_' . $patient->id . '_' . Str::uuid() . '.' . $extension;
        $path = 'profile-pictures/patient_' . $patient->id . '/' . $safeFileName;

        $fileContent = base64_encode($file->get());

        $patient->update(['profile_picture_path' => $path]);

        UploadProfilePictureToGcp::dispatch($patient, $fileContent);

        return $patient;
    }
}
