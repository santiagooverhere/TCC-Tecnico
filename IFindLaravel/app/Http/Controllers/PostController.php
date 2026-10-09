<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    public function store(StorePostRequest $request)
    {
        $dados = $request->validated();
        unset($dados['imagem']);

        if (! $request->user()->is_admin) {
            $dados['users_id'] = $request->user()->id;
        }

        $dados['imagemurl'] = $request->file('imagem')->store('posts', config('filesystems.imagens'));

        Post::create($dados);

        $destino = $request->user()->is_admin ? 'admin.dashboard' : 'dashboard';
        return redirect()
            ->route($destino)
            ->with('success', 'Post criado com sucesso!');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'comentarios']);
        return view('posts.show', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        if (! $request->user()->is_admin && ($request->user()->id !== $post->users_id || $post->data_devolvida)) {
            abort(403, 'Não é possível editar um post já devolvido.');
        }

        $dados = $request->validated();
        unset($dados['imagem']);

        if (! $request->user()->is_admin) {
            $dados['users_id'] = $post->users_id;
        }

        if ($request->hasFile('imagem')) {
            $dados['imagemurl'] = $request->file('imagem')->store('posts', config('filesystems.imagens'));
        }

        $post->update($dados);

        $destino = $request->user()->is_admin ? 'admin.dashboard' : 'dashboard';
        return redirect()
            ->route($destino)
            ->with('success', 'Post atualizado com sucesso!');
    }

    public function destroy(Request $request, Post $post)
    {
        if (! $request->user()->is_admin) {
            abort(403, 'Apenas administradores podem excluir posts.');
        }

        $post->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Post removido com sucesso!');
    }

    public function resolver(Request $request, Post $post)
    {
        if (! $request->user()->is_admin && $request->user()->id !== $post->users_id) {
            abort(403, 'Você só pode marcar seus próprios posts como devolvidos.');
        }

        $post->update(['data_devolvida' => now()]);
        return redirect()
            ->back()
            ->with('success', 'Item marcado como devolvido!');
    }
}
