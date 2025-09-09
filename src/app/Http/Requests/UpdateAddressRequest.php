<?php

namespace App\Http\Requests;

class UpdateAddressRequest extends PatientDependencyRequest
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
            'street' => 'sometimes|string|max:255',
            'number' => 'sometimes|string|max:255',
            'neighborhood' => 'sometimes|string|max:255',
            'city' => 'sometimes|string|max:255',
            'cep' => 'sometimes|string|max:255',
            'reference_point' => 'sometimes|string|max:255',
        ];

        return array_merge($rules, parent::rules());
    }
}
