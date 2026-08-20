<?php

namespace App\Http\Requests;

use App\Enums\EnumGenderPerson;
use App\Rules\CPF;
use App\Rules\UniqueNormalizedCpf;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCaregiverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $caregiverId = request()->route('caregiver');

        return [
            'full_name' => 'sometimes|string|max:255',
            'birth_date' => 'sometimes|date_format:m-d-Y',
            'gender' => ['sometimes', 'string', Rule::in(EnumGenderPerson::values())],
            'cpf' => [
                'sometimes',
                'string',
                new UniqueNormalizedCpf('caregivers', $caregiverId),
                new CPF,
            ],
            'rg' => [
                'sometimes',
                'string',
                Rule::unique('caregivers')->ignore($caregiverId)
            ],
            'education_level' => 'sometimes|string',
        ];
    }
}
