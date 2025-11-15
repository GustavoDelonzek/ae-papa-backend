<?php

namespace App\Http\Services;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Document;

readonly class DashboardService
{
    public function metrics(): array
    {
        return [
            'patient_count' => Patient::count(),
            'appointments_count' => Appointment::where('created_at', '>=', now()->startOfDay())
                ->where('created_at', '<=', now()->endOfDay())
                ->count(),
            'documents_count' => Document::count(),
        ];
    }
}
