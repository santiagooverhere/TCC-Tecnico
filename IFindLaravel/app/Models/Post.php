<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use SoftDeletes;
    protected $table = 'post'; //nome da tabela

    protected $fillable = [ //são os campos que podem ser preenchidos em massa
    'titulo', 'descricao', 'imagemurl', 'nome_item',
    'data_encontrada', 'data_devolvida', 'users_id',
];

    protected function casts(): array //transforma strings no banco para tipo PHP
{
    return [
        'data_encontrada' => 'datetime',
        'data_devolvida' => 'datetime',
    ];
}

    //cada post pertence a um usuário
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    //cada post pode ter vários comentários
    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class, 'post_id');
    }
}
