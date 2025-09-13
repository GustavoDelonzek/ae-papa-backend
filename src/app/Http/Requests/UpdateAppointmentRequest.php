<?php

namespace App\Http\Requests;

use App\Enums\EnumObjectiveAppointment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAppointmentRequest extends FormRequest
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
            'user_id' => 'sometimes|integer|exists:users,id', //Medical professional id
            'observations' => 'sometimes|string|max:255',
            'date' => 'sometimes|date_format:m-d-Y',
            'objective' => [
                'sometimes',
                'string',
                Rule::in(EnumObjectiveAppointment::values())
            ],
        ];
    }
}
