<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StorePostApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'descricao' => ['nullable', 'string'],
            'imagem'    => ['required', 'image', 'max:4096'],
            'nome_item' => ['required', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'imagem.required'     => 'A imagem do item é obrigatória.',
            'imagem.image'        => 'O arquivo enviado precisa ser uma imagem.',
            'imagem.max'          => 'A imagem não pode passar de 4MB.',
            'nome_item.required'  => 'Informe o nome do item.',
        ];
    }
}
