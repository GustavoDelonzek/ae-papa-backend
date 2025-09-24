<?php

namespace App\Http\Requests;

use App\Enums\EnumContactType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
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
            'owner_id'   => ['required', 'integer'],      
            'owner_type' => ['required', 'string'],       
            'type'       => ['required', 'string', Rule::in(EnumContactType::values())], 
            'value'      => ['required', 'string', 'max:255'], 
            'is_primary' => ['boolean'],                 
        ];
    }

}
