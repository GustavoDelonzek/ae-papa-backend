<?php

namespace App\Http\Requests;

use App\Enums\EnumKinshipCaregivers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttachPatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kinship' => ['required', 'string', Rule::in(EnumKinshipCaregivers::values())],
        ];
    }
}
