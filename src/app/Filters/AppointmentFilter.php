<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class AppointmentFilter extends AbstractQueryFilters
{
    private const SORTABLE_COLUMNS = ['date', 'objective', 'created_at'];

    public function applyFilters(): Builder
    {
        $query = parent::applyFilters();

        $this->applySorting();

        return $query;
    }

    public function patientId($patientId): void
    {
        $this->query->where('patient_id', $patientId);
    }

    public function userId($userId): void
    {
        $this->query->where('user_id', $userId);
    }

    public function date($date): void
    {
        $this->query->whereDate('date', $date);
    }

    public function startDate($date): void
    {
        $this->query->whereDate('date', '>=', $date);
    }

    public function endDate($date): void
    {
        $this->query->whereDate('date', '<=', $date);
    }

    public function objective($objective): void
    {
        $this->query->where('objective', $objective);
    }

    public function search($search): void
    {
        if (!$search) {
            return;
        }

        $this->query->whereHas('patient', function (Builder $query) use ($search) {
            $query->where('full_name', 'ilike', '%' . $search . '%');
        });
    }

    private function applySorting(): void
    {
        $sortBy = data_get($this->filters, 'sort_by');
        $sortOrder = strtolower((string) data_get($this->filters, 'sort_order')) === 'asc' ? 'asc' : 'desc';

        if (!in_array($sortBy, self::SORTABLE_COLUMNS, true)) {
            $this->query->orderBy('date', 'desc')->orderBy('id', 'desc');

            return;
        }

        $this->query->orderBy($sortBy, $sortOrder)->orderBy('id', 'desc');
    }
}
