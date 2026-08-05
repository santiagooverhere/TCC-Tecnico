@extends('layouts.admin')

@section('title', 'Editar Post')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Editar Post #{{ $post->id }}</h1>

    <form action="{{ route('posts.update', $post) }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf
        @method('PUT')
        @include('posts._form')
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection