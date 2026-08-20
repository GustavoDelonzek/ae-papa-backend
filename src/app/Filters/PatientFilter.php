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

    private const SORTABLE_COLUMNS = ['full_name', 'cpf', 'birth_date', 'created_at'];

    public function applyFilters(): Builder
    {
        $this->byStatus();
        $this->bySearch();
        $this->byFullName();
        $this->byGender();
        $this->byMaritalStatus();
        $this->byCpf();
        $this->byAgeFilter();
        $this->byBirthYearFilter();
        $this->byBirthMonthFilter();
        $this->applySorting();

        return $this->patients;
    }

    public function bySearch()
    {
        $search = data_get($this->filters, 'search');

        if (!$search) {
            return;
        }

        $digits = preg_replace('/\D/', '', $search);

        $this->patients->where(function (Builder $query) use ($search, $digits) {
            $query->where('full_name', 'ilike', '%' . $search . '%');

            if ($digits !== '') {
                $query->orWhereRaw("regexp_replace(cpf, '\D', '', 'g') LIKE ?", ['%' . $digits . '%']);
            }
        });
    }

    public function applySorting()
    {
        $sortBy = data_get($this->filters, 'sort_by');
        $sortOrder = strtolower((string) data_get($this->filters, 'sort_order')) === 'desc' ? 'desc' : 'asc';

        if (!in_array($sortBy, self::SORTABLE_COLUMNS, true)) {
            $this->patients->orderBy('full_name')->orderBy('id');

            return;
        }

        $this->patients->orderBy($sortBy, $sortOrder)->orderBy('id');
    }

    public function byStatus()
    {
        if (isset($this->filters['status'])) {
            $status = filter_var($this->filters['status'], FILTER_VALIDATE_BOOLEAN);

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
        $cpf = data_get($this->filters, 'cpf');

        if (!$cpf) {
            return;
        }

        $digits = preg_replace('/\D/', '', $cpf);

        if ($digits === '') {
            $this->patients->where('cpf', 'ilike', '%' . $cpf . '%');

            return;
        }

        $this->patients->whereRaw("regexp_replace(cpf, '\D', '', 'g') LIKE ?", ['%' . $digits . '%']);
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
