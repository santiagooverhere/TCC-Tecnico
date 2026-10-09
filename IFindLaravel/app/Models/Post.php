<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use SoftDeletes;
    protected $table = 'post';

    protected $fillable = [
        'descricao', 'imagemurl', 'nome_item',
        'data_encontrada', 'data_devolvida', 'users_id',
    ];

    protected function casts(): array
    {
        return [
            'data_encontrada' => 'datetime',
            'data_devolvida' => 'datetime',
        ];
    }

    public function getImagemExibicaoAttribute(): string
    {
        if ($this->imagemurl) {
            return Storage::disk(config('filesystems.imagens'))->url($this->imagemurl);
        }
        return 'https://placehold.co/400x200/e8f5ee/007A3D?text=IFIND';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class, 'post_id');
    }
}
