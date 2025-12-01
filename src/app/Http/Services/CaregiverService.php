<?php

namespace App\Http\Services;

use App\Models\Caregiver;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

readonly class CaregiverService
{
    public function getAllCaregivers(?int $perPage = 15, ?string $fullName = null): LengthAwarePaginator
    {
        $query = Caregiver::withoutGlobalScope(\Illuminate\Database\Eloquent\SoftDeletingScope::class);
        
        if ($fullName) {
            $query->where('full_name', 'ilike', '%' . $fullName . '%');
        }
        
        return $query->paginate($perPage);
    }

    public function storeCaregiver(array $data): Caregiver
    {
        return Caregiver::create([
            'patient_id' => data_get($data, 'patient_id'),
            'birth_date' => data_get($data, 'birth_date'),
            'full_name' => data_get($data, 'full_name'),
            'relationship' => data_get($data, 'relationship'),
            'gender' => data_get($data, 'gender'),
            'cpf' => data_get($data, 'cpf'),
            'rg' => data_get($data, 'rg'),
        ]);
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
