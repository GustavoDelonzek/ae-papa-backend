<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

use function PHPUnit\Framework\isNull;

class PatientFilter
{
    public function __construct(
        private readonly array|null $filters,
        private readonly Builder $patients
    ) {
    }

    public function applyFilters(): Collection
    {
        $this->byStatus();
        $this->byFullName();
        $this->byGender();
        $this->byMaritalStatus();

        return $this->patients->get();
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
            $this->patients->where('full_name', 'like', '%'.$fullName.'%');
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
}
