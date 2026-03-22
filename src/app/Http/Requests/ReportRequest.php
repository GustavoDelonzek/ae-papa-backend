<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'columns' => 'required|array|min:1',
            'columns.*' => 'string|in:personal_info,clinical_records,socioeconomic_history,attendance_frequency',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'detail_level' => 'required|string|in:complete,resumed',
            'format' => 'required|string|in:pdf,xlsx,csv',
        ];
    }
}
