<?php

namespace App\Http\Requests;

use App\Enums\EnumGenderPerson;
use App\Enums\EnumMaritalStatus;
use App\Enums\EnumRelationshipCaregivers;
use App\Rules\CPF;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCaregiverRequest extends PatientDependencyRequest
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
        $rules = [
            'full_name' => 'required|string|max:255',
            'birth_date' => 'required|date_format:m-d-Y',
            'relationship' => ['required', 'string', Rule::in(EnumRelationshipCaregivers::values())],
            'gender' => ['required', 'string', Rule::in(EnumGenderPerson::values())],
            'marital_status' => ['required', 'string', Rule::in(EnumMaritalStatus::values())],
            'cpf' => [
                'required',
                'string',
                'unique:patients,cpf',
                new CPF,
            ],
            'rg' => 'sometimes|string|unique:patients,rg',
        ];

        return array_merge($rules, parent::rules());
    }
}
