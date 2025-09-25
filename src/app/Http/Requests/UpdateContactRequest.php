<?php

namespace App\Http\Requests;

use App\Enums\EnumContactType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type'       => ['sometimes', 'string', Rule::in(EnumContactType::values())],
            'value'      => ['sometimes', 'string', 'max:255'],
            'is_primary' => ['boolean'],
        ];
    }

}
