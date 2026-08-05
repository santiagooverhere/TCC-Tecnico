@extends('layouts.admin')

@section('title', 'Comentários')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-4">
        <h1>Comentários</h1>
        <a href="{{ route('comentarios.create') }}" class="btn btn-success">Novo Comentário</a>
    </div>

    <table class="table bg-white rounded shadow-sm">
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Post</th>
                <th>Nome</th>
                <th>Texto</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($comentarios as $c)
                <tr>
                    <td>{{ $c->user->name ?? $c->users_id }}</td>
                    <td>{{ $c->post->titulo ?? $c->post_id }}</td>
                    <td>{{ $c->name_user }}</td>
                    <td>{{ Str::limit($c->texto, 50) }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('comentarios.edit', [$c->users_id, $c->post_id]) }}"
                           class="btn btn-sm btn-outline-primary">Editar</a>
                        <form action="{{ route('comentarios.destroy', [$c->users_id, $c->post_id]) }}"
                              method="POST" onsubmit="return confirm('Remover?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Remover</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Nenhum comentário.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $comentarios->links() }}
</div>
@endsection