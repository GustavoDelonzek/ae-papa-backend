<?php

namespace App\Filters;

class FamilyMemberFilter extends AbstractQueryFilters
{
    public function patientId($patientId): void
    {
        $this->query->where('patient_id', $patientId);
    }

    public function kinship($kinship): void
    {
        $this->query->where('kinship', 'ILIKE', '%' . $kinship . '%');
    }

    public function occupation($occupation): void
    {
        $this->query->where('occupation', 'ILIKE', '%' . $occupation . '%');
    }

    public function fullName($fullName): void
    {
        $this->query->where('full_name', 'ILIKE', '%' . $fullName . '%');
    }
}

