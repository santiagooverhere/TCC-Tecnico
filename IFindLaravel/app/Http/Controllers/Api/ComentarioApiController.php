<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreComentarioApiRequest;
use App\Http\Resources\ComentarioResource;
use App\Models\Comentario;
use App\Models\Post;
use Illuminate\Http\Request;

class ComentarioApiController extends Controller
{
    public function index(Post $post)
    {
        $comentarios = $post->comentarios()->latest()->get();
        return ComentarioResource::collection($comentarios);
    }

    public function store(StoreComentarioApiRequest $request, Post $post)
    {
        $comentario = Comentario::create([
            'users_id'  => $request->user()->id,
            'post_id'   => $post->id,
            'name_user' => $request->user()->name,
            'texto'     => $request->validated()['texto'],
        ]);
        return new ComentarioResource($comentario);
    }

    public function destroy(Request $request, Comentario $comentario)
    {
        if (! $request->user()->is_admin && $request->user()->id !== $comentario->users_id) {
            abort(403, 'Você só pode excluir seus próprios comentários.');
        }

        $comentario->delete();
        return response()->json(['message' => 'Comentário removido com sucesso.']);
    }
}
