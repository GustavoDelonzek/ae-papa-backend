<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Pacientes</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1, h2 { color: #333; }
        .patient-block { page-break-inside: avoid; border-bottom: 2px solid #333; margin-bottom: 30px; padding-bottom: 10px; }
        .section-title { background: #eee; padding: 5px; font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Relatório de Pacientes - AEPAPA</h1>
    <p>Período: {{ $start_date ?? 'Início' }} até {{ $end_date ?? 'Fim' }}</p>
    <p>Nível de detalhamento: {{ $detail_level === 'complete' ? 'Completo' : 'Resumido' }}</p>

    @foreach($patients as $patient)
        <div class="patient-block">
            <h2>{{ $patient->full_name }}</h2>
            
            @if(in_array('personal_info', $columns))
                <div class="section-title">Informações Pessoais</div>
                <table>
                    <tr>
                        <th>CPF</th><td>{{ $patient->cpf }}</td>
                        <th>RG</th><td>{{ $patient->rg }}</td>
                    </tr>
                    <tr>
                        <th>Data Nasc.</th><td>{{ $patient->birth_date }}</td>
                        <th>Gênero</th><td>{{ $patient->gender }}</td>
                    </tr>
                </table>
            @endif

            @if(in_array('clinical_records', $columns) && $patient->clinicalRecord)
                <div class="section-title">Registro Clínico</div>
                <table>
                    <tr>
                        <th>Data Diagnóstico</th><td>{{ $patient->clinicalRecord->diagnosis_date?->format('d/m/Y') }}</td>
                        <th>Estágio</th><td>{{ $patient->clinicalRecord->disease_stage }}</td>
                    </tr>
                    @if($detail_level === 'complete')
                        <tr>
                            <th>Médico</th><td>{{ $patient->clinicalRecord->responsible_doctor }}</td>
                            <th>Estado Emocional</th><td>{{ $patient->clinicalRecord->emotional_state }}</td>
                        </tr>
                        <tr>
                            <th colspan="4">Comorbidades</th>
                        </tr>
                        <tr>
                            <td colspan="4">{{ is_array($patient->clinicalRecord->comorbidities) ? implode(', ', $patient->clinicalRecord->comorbidities) : $patient->clinicalRecord->comorbidities }}</td>
                        </tr>
                    @endif
                </table>
            @endif

            @if(in_array('socioeconomic_history', $columns) && $patient->socioeconomicProfile)
                <div class="section-title">Histórico Socioeconômico</div>
                <table>
                    <tr>
                        <th>Fonte Renda</th><td>{{ $patient->socioeconomicProfile->income_source }}</td>
                        <th>Moradia</th><td>{{ $patient->socioeconomicProfile->housing_ownership }}</td>
                    </tr>
                    @if($detail_level === 'complete')
                        <tr>
                            <th>Residentes</th><td>{{ $patient->socioeconomicProfile->number_of_residents }}</td>
                            <th>Cômodos</th><td>{{ $patient->socioeconomicProfile->number_of_rooms }}</td>
                        </tr>
                    @endif
                </table>
            @endif

            @if(in_array('attendance_frequency', $columns))
                <div class="section-title">Frequência de Atendimento ({{ $patient->appointments->count() }})</div>
                @if($patient->appointments->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Tipo de Atendimento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patient->appointments as $appointment)
                                <tr>
                                    <td>{{ Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
                                    <td>{{ \App\Enums\EnumObjectiveAppointment::fromValue($appointment->objective) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endif
        </div>
    @endforeach
</body>
</html>
