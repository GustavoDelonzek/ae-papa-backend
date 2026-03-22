<?php

namespace App\Http\Services;

use App\Filters\ReportFilter;
use App\Models\ClinicalRecord;
use App\Models\SocioeconomicProfile;
use App\Models\Patient;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class ReportService
{
    public function generateReport(array $data)
    {
        $patients = $this->fetchData($data);
        $format = $data['format'];

        if ($format === 'pdf') {
            return $this->generatePdf($patients, $data);
        }

        return $this->generateExcel($patients, $data, $format);
    }

    private function fetchData(array $data): Collection
    {
        return (new ReportFilter($data, Patient::query()))->applyFilters()->get();
    }

    private function generatePdf(Collection $patients, array $data)
    {
        $pdf = Pdf::loadView('reports.patients', [
            'patients' => $patients,
            'columns' => $data['columns'],
            'detail_level' => $data['detail_level'],
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
        ]);

        return $pdf->download('relatorio_pacientes_' . now()->format('YmdHis') . '.pdf');
    }

    private function generateExcel(Collection $patients, array $data, string $format)
    {
        $export = new \App\Exports\PatientsExport($patients, $data['columns'], $data['detail_level']);
        $filename = 'relatorio_pacientes_' . now()->format('YmdHis') . '.' . $format;
        $excelFormat = $format === 'xlsx' ? \Maatwebsite\Excel\Excel::XLSX : \Maatwebsite\Excel\Excel::CSV;

        return Excel::download($export, $filename, $excelFormat);
    }

    public function stats(): array
    {
        return [
            'patient_count' => Patient::count(),
            'clinical_record_count' => ClinicalRecord::count(),
            'socioeconomic_profile_count' => SocioeconomicProfile::count(),
        ];
    }
}
