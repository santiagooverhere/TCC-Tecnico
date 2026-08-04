<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo'          => ['required', 'string', 'max:50'],
            'descricao'       => ['nullable', 'string'],
            'imagemurl'       => ['required', 'string'],
            'nome_item'       => ['required', 'string', 'max:100'],
            'data_encontrada' => ['nullable', 'date'],
            'data_devolvida'  => ['nullable', 'date'],
            'users_id'        => ['required', 'exists:users,id'],
        ];
    }

        public function messages(): array
    {
        return [
            'titulo.required'   => 'O título é obrigatório.',
            'users_id.required' => 'Selecione o usuário autor do post.',
            'users_id.exists'   => 'Usuário inválido.',
        ];
    }
}
