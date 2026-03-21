<?php

namespace App\Http\Requests;

use App\Enums\EnumKinshipCaregivers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CaregiverFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['sometimes', 'string'],
            'gender' => ['sometimes', 'string'],
            'cpf' => ['sometimes', 'string'],
            'kinship' => ['sometimes', 'string', Rule::in(EnumKinshipCaregivers::values())],
            'age_filter' => ['sometimes', 'string', 'regex:/^\d+(?:-\d+|\+)$/'],
            'ageFilter' => ['sometimes', 'string', 'regex:/^\d+(?:-\d+|\+)$/'],
            'birth_year' => ['sometimes', 'integer', 'min:1900', 'max:' . date('Y')],
            'birthYear' => ['sometimes', 'integer', 'min:1900', 'max:' . date('Y')],
        ];
    }
}
