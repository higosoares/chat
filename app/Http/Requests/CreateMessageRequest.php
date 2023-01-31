<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'receiver_id' => 'required|exists:App\Models\User,id',
            'text' => 'required|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'receiver_id.required' => 'O usuário que recebe a mensagem deve ser informado.',
            'receiver_id.exists' => 'O usuário informado inválido.',
            'text.required' => 'A mensagem é obrigatória.',
            'text.max' => 'A mensagem deve ter no máximo 255 caracteres.',
        ];
    }
}
