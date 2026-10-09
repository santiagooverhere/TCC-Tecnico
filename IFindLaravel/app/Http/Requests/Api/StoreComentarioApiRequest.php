<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreComentarioApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'texto' => ['required', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'texto.required' => 'Escreva um comentário.',
            'texto.max'      => 'O comentário não pode passar de 1000 caracteres.',
        ];
    }
}
