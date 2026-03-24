<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ReportFilter
{
    public function __construct(
        private readonly array $filters,
        private readonly Builder $query
    ) {
    }

    public function applyFilters(): Builder
    {
        $this->byPeriod();
        $this->includeRelations();

        return $this->query;
    }

    private function parseDate($date)
    {
        if (!$date) return null;
        return \Carbon\Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
    }

    private function byPeriod(): void
    {
        $startDate = $this->parseDate(data_get($this->filters, 'start_date'));
        $endDate = $this->parseDate(data_get($this->filters, 'end_date'));

        if ($startDate || $endDate) {
            $this->query->where(function ($q) use ($startDate, $endDate) {
                if ($startDate) {
                    $q->where('created_at', '>=', $startDate);
                }
                if ($endDate) {
                    $q->where('created_at', '<=', $endDate . ' 23:59:59');
                }

                $q->orWhereHas('appointments', function ($sq) use ($startDate, $endDate) {
                    if ($startDate) {
                        $sq->where('date', '>=', $startDate);
                    }
                    if ($endDate) {
                        $sq->where('date', '<=', $endDate);
                    }
                });
            });
        }
    }

    private function includeRelations(): void
    {
        $columns = data_get($this->filters, 'columns', []);
        $startDate = $this->parseDate(data_get($this->filters, 'start_date'));
        $endDate = $this->parseDate(data_get($this->filters, 'end_date'));

        $with = [];
        if (in_array('clinical_records', $columns)) {
            $with[] = 'clinicalRecord';
        }
        if (in_array('socioeconomic_history', $columns)) {
            $with[] = 'socioeconomicProfile';
        }

        if (in_array('attendance_frequency', $columns)) {
            $with['appointments'] = function ($q) use ($startDate, $endDate) {
                if ($startDate) {
                    $q->where('date', '>=', $startDate);
                }
                if ($endDate) {
                    $q->where('date', '<=', $endDate);
                }
            };
        }

        $this->query->with($with);
    }
}
