<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreComentarioRequest;
use App\Http\Requests\UpdateComentarioRequest;

class ComentarioController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComentarioRequest $request)
    {
        Comentario::create($request->validated());
        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Comentário criado com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComentarioRequest $request, Comentario $comentario)
    {
        $comentario->update($request->validated());
        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Comentário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comentario $comentario)
    {
        $comentario->delete();
        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Comentário removido com sucesso!');
    }
}
