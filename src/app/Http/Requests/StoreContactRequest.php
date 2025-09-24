<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\EnumContactType;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            
            'owner_id'   => ['required', 'integer'],           
            'owner_type' => ['required', 'string'],          
            'type' => ['required', new Enum(EnumContactType::class)],
            'value'      => ['required', 'string', 'max:255'],
            'is_primary' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'owner_id.required'   => 'O campo owner_id é obrigatório.',
            'owner_type.required' => 'O campo owner_type é obrigatório.',
            'type.required'       => 'O tipo de contato é obrigatório.',
            'type.in'             => 'O tipo de contato deve ser: email, phone ou whatsapp.',
            'value.required'      => 'O valor do contato é obrigatório.',
        ];
    }
}
