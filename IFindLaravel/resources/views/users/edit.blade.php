@extends('layouts.admin')
@section('title', 'Novo Usuário')
@section('content')
<div class="container py-4">
    <h1 class="mb-4">Editar Usuário</h1>
    <form action="{{ route('users.update', $user) }}" method="PUT" class="bg-white p-4 rounded shadow-sm">
        @csrf
        @include('users._form')
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection