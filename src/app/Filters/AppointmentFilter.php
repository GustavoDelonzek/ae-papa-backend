<?php

namespace App\Filters;

class AppointmentFilter extends AbstractQueryFilters
{
    public function patientId($patientId): void
    {
        $this->query->where('patient_id', $patientId);
    }

    public function date($date): void
    {
        $this->query->whereDate('date', $date);
    }

    public function status($status): void
    {
        $this->query->where('status', $status);
    }
}
