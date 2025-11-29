<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSocioeconomicProfileRequest extends FormRequest
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
            'patient_id' => ['required', 'exists:patients,id'],
            'income_source' => ['sometimes', 'string'],
            'housing_ownership' => ['sometimes', 'string'],
            'construction_type' => ['sometimes', 'string'],
            'sanitation_details' => ['sometimes', 'string'],
            'number_of_rooms' => ['sometimes', 'integer', 'min:1'],
            'number_of_residents' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
