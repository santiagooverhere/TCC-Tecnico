@extends('layouts.admin')

@section('title', 'Usuários — IFIND Admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Usuários</h1>
        <a href="{{ route('users.create') }}" class="btn btn-success">Novo Usuário</a>
    </div>

    <table class="table table-hover bg-white rounded shadow-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Posts</th>
                <th>Cadastro</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->posts_count }}</td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                              onsubmit="return confirm('Remover este usuário?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Remover</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Nenhum usuário.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection