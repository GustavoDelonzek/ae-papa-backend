<?php

namespace App\Http\Services;

use App\Enums\EnumObjectiveAppointment;
use App\Models\Appointment;
use App\Models\ClinicalRecord;
use App\Models\Document;
use App\Models\Patient;
use App\Models\SocioeconomicProfile;
use Carbon\Carbon;
use Illuminate\Support\Collection;

readonly class DashboardService
{
    public function metrics(): array
    {
        $clinicalRecordsTotal = ClinicalRecord::count();
        $socioeconomicProfilesTotal = SocioeconomicProfile::count();

        return [
            'patient_count' => Patient::count(),
            'appointments_count' => Appointment::where('created_at', '>=', now()->startOfDay())
                ->where('created_at', '<=', now()->endOfDay())
                ->count(),
            'documents_count' => Document::count(),
            'clinical_records_count' => $clinicalRecordsTotal,
            'socioeconomic_profiles_count' => $socioeconomicProfilesTotal,
        ];
    }

    public function statistics(array $filters): array
    {
        $months = (int) data_get($filters, 'months', 12);
        $months = max(1, min($months, 24));

        $endDate = now()->endOfMonth();
        $startDate = now()->subMonths($months - 1)->startOfMonth();

        $appointmentsByMonthRaw = Appointment::query()
            ->selectRaw("TO_CHAR(date, 'YYYY-MM') as month, COUNT(*) as total")
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->groupByRaw("TO_CHAR(date, 'YYYY-MM')")
            ->orderByRaw("TO_CHAR(date, 'YYYY-MM')")
            ->pluck('total', 'month');

        $newPatientsByMonthRaw = Patient::withTrashed()
            ->selectRaw("TO_CHAR(created_at, 'YYYY-MM') as month, COUNT(*) as total")
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupByRaw("TO_CHAR(created_at, 'YYYY-MM')")
            ->orderByRaw("TO_CHAR(created_at, 'YYYY-MM')")
            ->pluck('total', 'month');

        $appointmentsByTypeRaw = Appointment::query()
            ->selectRaw('objective, COUNT(*) as total')
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->groupBy('objective')
            ->pluck('total', 'objective');

        $patientsActiveTotal = Patient::query()->count();
        $patientsInactiveTotal = Patient::onlyTrashed()->count();
        $newPatientsTotal = (int) Patient::withTrashed()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $appointmentsTotalInPeriod = (int) Appointment::query()
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->count();
        $clinicalRecordsTotal = ClinicalRecord::count();
        $socioeconomicProfilesTotal = SocioeconomicProfile::count();

        return [
            'period' => [
                'start' => $startDate->toDateString(),
                'end' => $endDate->toDateString(),
                'months' => $months,
            ],
            'totals' => [
                'patients_active' => $patientsActiveTotal,
                'patients_inactive' => $patientsInactiveTotal,
                'new_patients' => $newPatientsTotal,
                'appointments' => $appointmentsTotalInPeriod,
                'clinical_records' => $clinicalRecordsTotal,
                'socioeconomic_profiles' => $socioeconomicProfilesTotal,
            ],
            'appointments_by_month' => $this->buildMonthSeries($startDate, $months, $appointmentsByMonthRaw),
            'patients_active_inactive' => [
                'active' => $patientsActiveTotal,
                'inactive' => $patientsInactiveTotal,
            ],
            'new_patients' => [
                'total' => $newPatientsTotal,
                'by_month' => $this->buildMonthSeries($startDate, $months, $newPatientsByMonthRaw),
            ],
            'cancelled_appointments' => [
                'supported' => false,
                'total' => null,
                'reason' => 'appointments table does not have cancellation status or soft delete tracking',
            ],
            'appointments_by_type' => $this->buildObjectiveSeries($appointmentsByTypeRaw),
            'clinical_records' => [
                'total' => $clinicalRecordsTotal,
            ],
            'socioeconomic_profiles' => [
                'total' => $socioeconomicProfilesTotal,
            ],
            // Compatibility aliases for frontend payload readers.
            'clinical_records_total' => $clinicalRecordsTotal,
            'clinical_records_count' => $clinicalRecordsTotal,
            'socioeconomic_profiles_total' => $socioeconomicProfilesTotal,
            'socioeconomic_profiles_count' => $socioeconomicProfilesTotal,
        ];
    }

    private function buildMonthSeries(Carbon $startDate, int $months, Collection $totalsByMonth): array
    {
        $series = [];

        for ($i = 0; $i < $months; $i++) {
            $monthKey = $startDate->copy()->addMonths($i)->format('Y-m');
            $series[] = [
                'month' => $monthKey,
                'total' => (int) ($totalsByMonth->get($monthKey, 0)),
            ];
        }

        return $series;
    }

    private function buildObjectiveSeries(Collection $totalsByObjective): array
    {
        $series = [];

        foreach (EnumObjectiveAppointment::values() as $objective) {
            $series[] = [
                'objective' => $objective,
                'total' => (int) ($totalsByObjective->get($objective, 0)),
            ];
        }

        return $series;
    }
}
