<?php

namespace App\Http\Requests;

use App\Enums\EnumMaritalStatus;
use App\Rules\CPF;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
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
        $patientId = $this->route('patient')->id;

        return [
            'full_name' => ['sometimes', 'string', 'max:255'],
            'birth_date' => ['sometimes', 'date_format:m-d-Y'],
            'gender' => ['sometimes', 'string'],
            'marital_status' => ['sometimes', 'nullable', Rule::in(EnumMaritalStatus::values())],
            'cpf' => [
                'sometimes',
                'string',
                Rule::unique('patients')->ignore($patientId),
                new CPF,
            ],
            'rg' => [
                'sometimes',
                'string',
                Rule::unique('patients')->ignore($patientId),
            ],
        ];
    }
}
