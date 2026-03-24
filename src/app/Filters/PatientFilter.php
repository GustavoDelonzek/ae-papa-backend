<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class PatientFilter
{
    public function __construct(
        private readonly array|null $filters,
        private readonly Builder $patients
    ) {
    }

    public function applyFilters(): Builder
    {
        $this->byStatus();
        $this->byFullName();
        $this->byGender();
        $this->byMaritalStatus();
        $this->byCpf();
        $this->byAgeFilter();
        $this->byBirthYearFilter();
        $this->byBirthMonthFilter();

        return $this->patients;
    }

    public function byStatus()
    {
        if (isset($this->filters['status'])) {
            $status = (bool) $this->filters['status'];

            if ($status === true) {

            } else {
                $this->patients->onlyTrashed();
            }
        }
    }

    public function byFullName()
    {
        if ($fullName =data_get($this->filters, 'full_name')) {
            $this->patients->where('full_name', 'ilike', '%'.$fullName.'%');
        }
    }

    public function byGender()
    {
        if ($gender =data_get($this->filters, 'gender')) {
            $this->patients->where('gender', $gender);
        }
    }

    public function byMaritalStatus()
    {
        if ($maritalStatus = data_get($this->filters, 'marital_status')) {
            $this->patients->where('marital_status', $maritalStatus);
        }
    }

    public function byCpf()
    {
        if ($cpf = data_get($this->filters, 'cpf')) {
            $this->patients->where('cpf', 'ilike', '%'.$cpf.'%');
        }
    }

    public function byAgeFilter()
    {
        $ageFilter = data_get($this->filters, 'age_filter', data_get($this->filters, 'ageFilter'));

        if (!$ageFilter) {
            return;
        }

        if (preg_match('/^(\d+)-(\d+)$/', $ageFilter, $matches)) {
            $this->patients->whereRaw(
                "DATE_PART('year', AGE(CURRENT_DATE, birth_date)) BETWEEN ? AND ?",
                [(int) $matches[1], (int) $matches[2]]
            );

            return;
        }

        if (preg_match('/^(\d+)\+$/', $ageFilter, $matches)) {
            $this->patients->whereRaw(
                "DATE_PART('year', AGE(CURRENT_DATE, birth_date)) >= ?",
                [(int) $matches[1]]
            );
        }
    }

    public function byBirthYearFilter()
    {
        $birthYear = data_get($this->filters, 'birth_year', data_get($this->filters, 'birthYear'));

        if ($birthYear) {
            $this->patients->whereYear('birth_date', $birthYear);
        }
    }

    public function byBirthMonthFilter()
    {
        $birthMonth = data_get($this->filters, 'birth_month', data_get($this->filters, 'birthMonth'));

        if ($birthMonth) {
            $this->patients->whereMonth('birth_date', $birthMonth);
        }
    }
}
