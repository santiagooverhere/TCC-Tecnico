@extends('layouts.admin')

@section('title', 'Posts — IFIND Admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Posts</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Novo Post
        </a>
    </div>

    <div class="table-responsive bg-white rounded shadow-sm">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->nome_item }}</td>
                        <td>{{ $post->titulo }}</td>
                        <td>{{ $post->user->name ?? '—' }}</td>
                        <td>{{ $post->created_at->diffForHumans() }}</td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                  onsubmit="return confirm('Remover este post?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Remover</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Nenhum post cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $posts->links() }}
    </div>
</div>
@endsection