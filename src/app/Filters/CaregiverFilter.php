<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class CaregiverFilter
{
    public function __construct(
        private readonly ?array $filters,
        private readonly Builder $caregivers
    ) {
    }

    public function applyFilters(): Builder
    {
        $this->byFullName();
        $this->byGender();
        $this->byCpf();
        $this->byKinship();
        $this->byAgeFilter();
        $this->byBirthYearFilter();

        return $this->caregivers;
    }

    public function byFullName()
    {
        if ($fullName = data_get($this->filters, 'full_name')) {
            $this->caregivers->where('full_name', 'ilike', '%' . $fullName . '%');
        }
    }

    public function byGender()
    {
        if ($gender = data_get($this->filters, 'gender')) {
            $this->caregivers->where('gender', $gender);
        }
    }

    public function byCpf()
    {
        if ($cpf = data_get($this->filters, 'cpf')) {
            $this->caregivers->where('cpf', 'ilike', '%' . $cpf . '%');
        }
    }

    public function byKinship()
    {
        if ($kinship = data_get($this->filters, 'kinship')) {
            $this->caregivers->whereHas('patients', function (Builder $query) use ($kinship) {
                $query->where('caregiver_patient.kinship', $kinship);
            });
        }
    }

    public function byAgeFilter()
    {
        $ageFilter = data_get($this->filters, 'age_filter', data_get($this->filters, 'ageFilter'));

        if (!$ageFilter) {
            return;
        }

        if (preg_match('/^(\d+)-(\d+)$/', $ageFilter, $matches)) {
            $this->caregivers->whereRaw(
                "DATE_PART('year', AGE(CURRENT_DATE, birth_date)) BETWEEN ? AND ?",
                [(int) $matches[1], (int) $matches[2]]
            );

            return;
        }

        if (preg_match('/^(\d+)\+$/', $ageFilter, $matches)) {
            $this->caregivers->whereRaw(
                "DATE_PART('year', AGE(CURRENT_DATE, birth_date)) >= ?",
                [(int) $matches[1]]
            );
        }
    }

    public function byBirthYearFilter()
    {
        $birthYear = data_get($this->filters, 'birth_year', data_get($this->filters, 'birthYear'));

        if ($birthYear) {
            $this->caregivers->whereYear('birth_date', $birthYear);
        }
    }
}
