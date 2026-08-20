<?php

namespace App\Http\Requests;

use App\Enums\EnumGenderPerson;
use App\Enums\EnumMaritalStatus;
use App\Rules\CPF;
use App\Rules\UniqueNormalizedCpf;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePatientRequest extends FormRequest
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
            'full_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date_format:m-d-Y'],
            'gender' => ['required', 'string', Rule::in(EnumGenderPerson::values())],
            'marital_status' => ['required', 'string', Rule::in(EnumMaritalStatus::values())],
            'cpf' => [
                'required',
                'string',
                new UniqueNormalizedCpf('patients'),
                new CPF,
            ],
            'rg' => ['sometimes', 'nullable', 'string', 'unique:patients,rg'],
        ];
    }
}
