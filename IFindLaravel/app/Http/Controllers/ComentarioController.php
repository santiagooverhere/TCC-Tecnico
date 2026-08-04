<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreComentarioRequest;
use App\Http\Requests\UpdateComentarioRequest;
use App\Models\Post;
use App\Models\User;

class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comentarios = Comentario::with(['user', 'post'])
            ->latest()
            ->paginate(10);
        return view('comentarios.index', compact('comentarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $posts = Post::orderBy('titulo')->get();
        return view('comentarios.create', compact('users', 'posts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComentarioRequest $request)
    {
        Comentario::create($request->validated());
        return redirect()
            ->route('comentarios.index')
            ->with('success', 'Comentário criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comentario $comentario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $users_id, int $post_id)
    {
        $comentario = Comentario::where('users_id', $users_id)
            ->where('post_id', $post_id)
            ->firstOrFail();
        return view('comentarios.edit', compact('comentario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComentarioRequest $request, int $users_id, int $post_id)
    {
        $comentario = Comentario::where('users_id', $users_id)
            ->where('post_id', $post_id)
            ->firstOrFail();
        $comentario->update($request->validated());
        return redirect()
            ->route('comentarios.index')
            ->with('success', 'Comentário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(int $users_id, int $post_id)
    {
        $comentario = Comentario::where('users_id', $users_id)
            ->where('post_id', $post_id)
            ->firstOrFail();
        $comentario->delete();
        return redirect()
            ->route('comentarios.index')
            ->with('success', 'Comentário removido com sucesso!');
    }
}
