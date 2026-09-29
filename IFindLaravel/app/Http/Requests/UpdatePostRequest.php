<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'descricao'       => ['nullable', 'string'],
            'imagem'          => ['nullable', 'image', 'max:4096'],
            'nome_item'       => ['required', 'string', 'max:100'],
            'data_encontrada' => ['nullable', 'date'],
            'data_devolvida'  => ['nullable', 'date'],
            'users_id'        => ['required', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'imagem.image'      => 'O arquivo enviado precisa ser uma imagem.',
            'imagem.max'        => 'A imagem não pode passar de 4MB.',
            'users_id.required' => 'Selecione o usuário autor do post.',
            'users_id.exists'   => 'Usuário inválido.',
        ];
    }
}
