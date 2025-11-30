<?php

namespace App\Http\Requests;

use App\Enums\EnumGenderPerson;
use App\Enums\EnumKinshipCaregivers;
use App\Rules\CPF;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCaregiverRequest extends FormRequest
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
            'patient_id' => 'required|integer|exists:patients,id',
            'full_name' => 'required|string|max:255',
            'birth_date' => 'required|date_format:m-d-Y',
            'kinship' => ['required', 'string', Rule::in(EnumKinshipCaregivers::values())],
            'gender' => ['required', 'string', Rule::in(EnumGenderPerson::values())],
            'cpf' => [
                'required',
                'string',
                'unique:caregivers,cpf',
                new CPF,
            ],
            'rg' => 'sometimes|string|unique:caregivers,rg',
        ];
    }
}
