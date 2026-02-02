<?php

namespace App\Http\Requests;

use App\Enums\EnumGenderPerson;
use App\Enums\EnumKinshipCaregivers;
use App\Rules\CPF;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCaregiverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'sometimes|integer|exists:patients,id',
            'kinship' => ['required_with:patient_id', 'string', Rule::in(EnumKinshipCaregivers::values())],
            'full_name' => 'required|string|max:255',
            'birth_date' => 'required|date_format:m-d-Y',
            'gender' => ['required', 'string', Rule::in(EnumGenderPerson::values())],
            'cpf' => [
                'required',
                'string',
                'unique:caregivers,cpf',
                new CPF,
            ],
            'rg' => 'sometimes|string|unique:caregivers,rg',
            'education_level' => 'sometimes|string',
        ];
    }
}
