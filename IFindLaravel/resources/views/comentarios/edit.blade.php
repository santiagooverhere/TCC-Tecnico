@extends('layouts.admin')

@section('title', 'Novo Comentário')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Novo Comentário</h1>

    <form action="{{ route('comentarios.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf
        @method('PUT')
        @include('comentarios._form')
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('comentarios.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection