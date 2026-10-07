<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComentarioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'post_id'    => $this->post_id,
            'users_id'   => $this->users_id,
            'name_user'  => $this->name_user,
            'texto'      => $this->texto,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
