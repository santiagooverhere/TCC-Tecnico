@extends('layouts.admin')

@section('title', $post->titulo . ' — IFIND Admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $post->titulo }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">Editar</a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow-sm mb-4">
        <dl class="row mb-0">
            <dt class="col-sm-3">Item</dt>
            <dd class="col-sm-9">{{ $post->nome_item }}</dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $post->descricao ?: '—' }}</dd>

            <dt class="col-sm-3">Publicado por</dt>
            <dd class="col-sm-9">{{ $post->user->name ?? '—' }}</dd>

            <dt class="col-sm-3">Data encontrada</dt>
            <dd class="col-sm-9">{{ $post->data_encontrada?->format('d/m/Y H:i') ?? '—' }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                @if ($post->data_devolvida)
                    <span class="badge bg-primary">Devolvido em {{ $post->data_devolvida->format('d/m/Y H:i') }}</span>
                @else
                    <span class="badge bg-warning text-dark">Ainda perdido</span>
                @endif
            </dd>
        </dl>
    </div>

    <div class="bg-white p-4 rounded shadow-sm">
        <h5 class="mb-3">Comentários ({{ $post->comentarios->count() }})</h5>
        @forelse ($post->comentarios as $comentario)
            <div class="border-bottom py-2">
                <strong>{{ $comentario->name_user }}</strong>
                <p class="mb-0 text-muted">{{ $comentario->texto }}</p>
            </div>
        @empty
            <p class="text-muted mb-0">Nenhum comentário ainda.</p>
        @endforelse
    </div>
</div>
@endsection
