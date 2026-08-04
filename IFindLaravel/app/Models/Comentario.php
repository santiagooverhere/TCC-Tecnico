<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comentario extends Model
{
    use SoftDeletes;
    protected $table = 'comentario';

    protected $primaryKey = ['users_id', 'post_id'];
    public $incrementing = false;
    protected $fillable = [
    'users_id', 'post_id', 'name_user', 'texto',
    ];

        public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    //necessário para chave primária composta funcionar no Eloquent
    //para conseguir dar update e delete
    protected function setKeysForSaveQuery($query) 
    {
        $keys = $this->getKeyName();
        if (!is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }
        foreach ($keys as $keyName) {
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }
        return $query;
    }

        protected function getKeyForSaveQuery($keyName = null)
    {
        if (is_null($keyName)) {
            $keyName = $this->getKeyName();
        }
        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }
        return $this->getAttribute($keyName);
    }
}
