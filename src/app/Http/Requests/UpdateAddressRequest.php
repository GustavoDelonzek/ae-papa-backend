<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends PatientAddressRequest
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
            'street' => 'sometimes|string|max:255',
            'number' => 'sometimes|string|max:255',
            'neighborhood' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:255',
            'cep' => 'sometimes|string|max:255',
            'reference_point' => 'sometimes|string|max:255',
        ];
    }
}
