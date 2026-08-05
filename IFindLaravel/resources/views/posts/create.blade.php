@extends('layouts.admin')

@section('title', 'Novo Post')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Novo Post</h1>

    <form action="{{ route('posts.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf
        @include('posts._form')
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection