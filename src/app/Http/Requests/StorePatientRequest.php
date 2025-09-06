<?php

namespace App\Http\Requests;

use App\Enums\EnumMaritalStatus;
use App\Models\Patient;
use Illuminate\Foundation\Http\FormRequest;

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
            'full_name' => 'required|string',
            'birth_date' => 'required|date',
            'gender' => ['required', 'string', 'in:' . implode(',', Patient::GENDERS)],
            'marital_status' => ['required', 'string', 'nullable', 'in:' . implode(',', EnumMaritalStatus::values())],
            'cpf' => 'required|string', //TODO: validate cpf format
            'rg' => 'required|string',
        ];
    }
}
