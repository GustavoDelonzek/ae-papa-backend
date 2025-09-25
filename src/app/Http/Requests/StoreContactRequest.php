<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\EnumContactType;
use Illuminate\Validation\Rule;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required_if:caregiver_id,null|integer|exists:patients,id|prohibits:caregiver_id',
            'caregiver_id' => 'required_if:patient_id,null|integer|exists:caregivers,id|prohibits:patient_id',
            'type' => ['required', Rule::in(EnumContactType::values())],
            'value'      => ['required', 'string', 'max:255'],
            'is_primary' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required'       => 'O tipo de contato é obrigatório.',
            'type.in'             => 'O tipo de contato deve ser: email, phone ou whatsapp.',
            'value.required'      => 'O valor do contato é obrigatório.',
        ];
    }
}
