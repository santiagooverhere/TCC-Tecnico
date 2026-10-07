<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'nome_item'       => $this->nome_item,
            'descricao'       => $this->descricao,
            'imagem_url'      => str_starts_with($this->imagem_exibicao, 'http')
                ? $this->imagem_exibicao
                : url($this->imagem_exibicao),
            'data_encontrada' => $this->data_encontrada?->toIso8601String(),
            'data_devolvida'  => $this->data_devolvida?->toIso8601String(),
            'users_id'        => $this->users_id,
            'autor'           => $this->whenLoaded('user', fn () => [
                'id'    => $this->user->id,
                'name'  => $this->user->name,
                'email' => $this->user->email,
            ]),
            'created_at'      => $this->created_at?->toIso8601String(),
            'updated_at'      => $this->updated_at?->toIso8601String(),
        ];
    }
}
