<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientFilterRequest extends FormRequest
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
            'per_page' => 'sometimes|integer',
            'status' => 'sometimes|string',
            'full_name' => 'sometimes|string',
            'gender' => 'sometimes|string',
            'marital_status' => 'sometimes|string',
            'cpf' => 'sometimes|string',
            'age_filter' => ['sometimes', 'string', 'regex:/^\d+(?:-\d+|\+)$/'],
            'ageFilter' => ['sometimes', 'string', 'regex:/^\d+(?:-\d+|\+)$/'],
            'birth_year' => ['sometimes', 'integer', 'min:1900', 'max:' . date('Y')],
            'birthYear' => ['sometimes', 'integer', 'min:1900', 'max:' . date('Y')],
        ];
    }
}
