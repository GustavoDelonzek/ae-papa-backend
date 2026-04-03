<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PatientsExport implements FromCollection, WithHeadings, WithMapping
{
    private Collection $patients;
    private array $columns;
    private string $detailLevel;

    public function __construct(Collection $patients, array $columns, string $detailLevel)
    {
        $this->patients = $patients;
        $this->columns = $columns;
        $this->detailLevel = $detailLevel;
    }

    public function collection()
    {
        return $this->patients;
    }

    public function headings(): array
    {
        $headings = [];
        if (in_array('personal_info', $this->columns)) {
            $headings = array_merge($headings, ['Nome Completo', 'CPF', 'Data de Nascimento', 'Gênero']);
        }
        if (in_array('clinical_records', $this->columns)) {
            $headings[] = 'Data Diagnóstico';
            $headings[] = 'Estágio Doença';
            if ($this->detailLevel === 'complete') {
                $headings[] = 'Médico Responsável';
                $headings[] = 'Estado Emocional';
            }
        }
        if (in_array('socioeconomic_history', $this->columns)) {
            $headings[] = 'Fonte Renda';
            $headings[] = 'Tipo Moradia';
            if ($this->detailLevel === 'complete') {
                $headings[] = 'Moradores';
            }
        }
        if (in_array('attendance_frequency', $this->columns)) {
            $headings[] = 'Total de Atendimentos';
            $headings[] = 'Tipos de Atendimento';
        }
        return $headings;
    }

    public function map($patient): array
    {
        $map = [];
        if (in_array('personal_info', $this->columns)) {
            $map = array_merge($map, [
                $patient->full_name,
                $patient->cpf,
                $patient->birth_date,
                $patient->gender,
            ]);
        }
        if (in_array('clinical_records', $this->columns) && $patient->clinicalRecord) {
            $map[] = $patient->clinicalRecord->diagnosis_date?->format('d/m/Y');
            $map[] = $patient->clinicalRecord->disease_stage;
            if ($this->detailLevel === 'complete') {
                $map[] = $patient->clinicalRecord->responsible_doctor;
                $map[] = $patient->clinicalRecord->emotional_state;
            }
        } elseif (in_array('clinical_records', $this->columns)) {
            $map[] = null;
            $map[] = null;
            if ($this->detailLevel === 'complete') {
                $map[] = null;
                $map[] = null;
            }
        }
        
        if (in_array('socioeconomic_history', $this->columns) && $patient->socioeconomicProfile) {
            $map[] = $patient->socioeconomicProfile->income_source;
            $map[] = $patient->socioeconomicProfile->housing_ownership;
            if ($this->detailLevel === 'complete') {
                $map[] = $patient->socioeconomicProfile->number_of_residents;
            }
        } elseif (in_array('socioeconomic_history', $this->columns)) {
            $map[] = null;
            $map[] = null;
            if ($this->detailLevel === 'complete') {
                $map[] = null;
            }
        }

        if (in_array('attendance_frequency', $this->columns)) {
            $map[] = $patient->appointments->count();
            $types = $patient->appointments->map(fn($a) =>
                \App\Enums\EnumObjectiveAppointment::fromValue($a->objective)
            )->unique()->values()->implode(', ');
            $map[] = $types ?: '-';
        }
        return $map;
    }
}
