<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostApiController extends Controller
{

    public function index(Request $request)
    {
        $query = Post::with('user')->latest();

        if ($request->filled('busca')) {
            $termo = $request->input('busca');
            $query->where(function ($q) use ($termo) {
                $q->where('nome_item', 'like', "%{$termo}%")
                  ->orWhere('descricao', 'like', "%{$termo}%");
            });
        }

        if ($request->input('tipo') === 'perdido') {
            $query->whereNull('data_devolvida');
        } elseif ($request->input('tipo') === 'devolvido') {
            $query->whereNotNull('data_devolvida');
        }

        $posts = $query->paginate(20);

        return PostResource::collection($posts);
    }

    public function store(Request $request, StorePostRequest $storeRequest)
    {
        $storeRequest->merge(['users_id' => $request->user()->id]);

        $dados = $storeRequest->validated();
        unset($dados['imagem']);
        $dados['users_id'] = $request->user()->id;

        $dados['imagemurl'] = $storeRequest->file('imagem')->store('posts', 'public');

        $post = Post::create($dados);
        $post->load('user');

        return new PostResource($post);
    }

    public function show(Post $post)
    {
        $post->load(['user', 'comentarios']);
        return new PostResource($post);
    }

    public function update(Request $request, UpdatePostRequest $updateRequest, Post $post)
    {
        if (! $request->user()->is_admin && ($request->user()->id !== $post->users_id || $post->data_devolvida)) {
            abort(403, 'Não é possível editar um post já devolvido.');
        }

        $updateRequest->merge(['users_id' => $post->users_id]);

        $dados = $updateRequest->validated();
        unset($dados['imagem']);

        if ($updateRequest->hasFile('imagem')) {
            $dados['imagemurl'] = $updateRequest->file('imagem')->store('posts', 'public');
        }

        $post->update($dados);
        $post->load('user');

        return new PostResource($post);
    }

    public function destroy(Request $request, Post $post)
    {
        if (! $request->user()->is_admin) {
            abort(403, 'Apenas administradores podem excluir posts.');
        }

        $post->delete();

        return response()->json(['message' => 'Post removido com sucesso.']);
    }

    public function resolver(Request $request, Post $post)
    {
        if (! $request->user()->is_admin && $request->user()->id !== $post->users_id) {
            abort(403, 'Você só pode marcar seus próprios posts como devolvidos.');
        }

        $post->update(['data_devolvida' => now()]);
        $post->load('user');

        return new PostResource($post);
    }
}
