@extends('layouts.admin')

@section('title', 'Usuário — IFIND Admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $user->name }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">Editar</a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow-sm mb-4">
        <dl class="row mb-0">
            <dt class="col-sm-3">E-mail</dt>
            <dd class="col-sm-9">{{ $user->email }}</dd>

            <dt class="col-sm-3">Cadastrado em</dt>
            <dd class="col-sm-9">{{ $user->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Total de posts</dt>
            <dd class="col-sm-9">{{ $user->posts_count }}</dd>
        </dl>
    </div>
</div>
@endsection
