<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClinicalRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         return [
             'diagnosis_date' => ['nullable', 'date'],
             'disease_stage' => ['nullable', 'string', 'max:255'],
             'comorbidities' => ['nullable', 'array'],
             'comorbidities.*' => ['string', 'distinct'],
             'responsible_doctor' => ['nullable', 'string', 'max:255'],
             'health_unit_location' => ['nullable', 'string', 'max:255'],
             'medications_usage' => ['nullable', 'string'],
             'recognizes_family' => ['nullable', 'string', 'max:255'],
             'emotional_state' => ['nullable', 'string', 'max:255'],
             'wandering_risk' => ['boolean'],
             'verbal_communication' => ['boolean'],
             'disorientation_frequency' => ['boolean'],
             'has_falls_history' => ['boolean'],
             'needs_feeding_help' => ['boolean'],
             'needs_hygiene_help' => ['boolean'],
             'has_sleep_issues' => ['boolean'],
             'has_hallucinations' => ['boolean'],
             'reduced_mobility' => ['boolean'],
             'is_aggressive' => ['boolean'],
         ];
    }
}
