<?php

namespace App\Filters;

class ClinicalRecordFilter extends AbstractQueryFilters
{
    public function patientId(int $patientId): void
    {
        $this->query->where('patient_id', $patientId);
    }

    public function healthUnitLocation(string $healthUnitLocation): void
    {
        $this->query->where('health_unit_location', 'ILIKE', '%' . $healthUnitLocation . '%');
    }

    public function comorbidities(array $list): void
    {
        $this->query->where(function ($q) use ($list) {
            foreach ($list as $item) {
                $q->orWhereJsonContains('comorbidities', $item);
            }
        });
    }

    public function responsibleDoctor(string $responsibleDoctor): void
    {
        $this->query->where('responsible_doctor', 'ILIKE', '%' . $responsibleDoctor . '%');
    }

    public function hasRiskBehavior(bool $value): void
    {
        if (!$value) return;

        $this->query->where(function ($q) {
            $q->where('is_aggressive', true)
                ->orWhere('has_hallucinations', true)
                ->orWhere('wandering_risk', true);
        });
    }

    public function hasDependency(bool $value): void
    {
        if (!$value) return;

        $this->query->where(function ($q) {
            $q->where('needs_hygiene_help', true)
                ->orWhere('needs_feeding_help', true)
                ->orWhere('reduced_mobility', true)
                ->orWhere('disorientation_frequency', true);
        });
    }
}
