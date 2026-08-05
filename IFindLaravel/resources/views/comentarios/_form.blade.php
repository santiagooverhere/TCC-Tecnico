@if (!isset($comentario))
<div class="mb-3">
    <label class="form-label">Usuário</label>
    <select name="users_id" class="form-select @error('users_id') is-invalid @enderror">
        <option value="">Selecione...</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" @selected(old('users_id') == $user->id)>{{ $user->name }}</option>
        @endforeach
    </select>
    @error('users_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Post</label>
    <select name="post_id" class="form-select @error('post_id') is-invalid @enderror">
        <option value="">Selecione...</option>
        @foreach ($posts as $post)
            <option value="{{ $post->id }}" @selected(old('post_id') == $post->id)>{{ $post->titulo }}</option>
        @endforeach
    </select>
    @error('post_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
@endif

<div class="mb-3">
    <label class="form-label">Nome exibido</label>
    <input type="text" name="name_user" class="form-control @error('name_user') is-invalid @enderror"
           value="{{ old('name_user', $comentario->name_user ?? '') }}" maxlength="100">
    @error('name_user') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Texto</label>
    <textarea name="texto" class="form-control" rows="4">{{ old('texto', $comentario->texto ?? '') }}</textarea>
</div>