<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClinicalRecordFilterRequest extends FormRequest
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
            'patient_id' => ['sometimes', 'integer', 'exists:patients,id'],
            'health_unit_location' => ['sometimes', 'integer'],
            'comorbidities' => ['sometimes', 'array'],
            'has_risk_behavior' => ['sometimes', 'boolean'],
            'has_dependency' => ['sometimes', 'boolean'],
        ];
    }
}
