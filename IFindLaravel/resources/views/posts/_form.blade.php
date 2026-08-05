<div class="mb-3">
    <label class="form-label">Título</label>
    <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror"
           value="{{ old('titulo', $post->titulo ?? '') }}" maxlength="50">
    @error('titulo') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nome do item</label>
    <input type="text" name="nome_item" class="form-control @error('nome_item') is-invalid @enderror"
           value="{{ old('nome_item', $post->nome_item ?? '') }}" maxlength="100">
    @error('nome_item') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Descrição</label>
    <textarea name="descricao" class="form-control @error('descricao') is-invalid @enderror" rows="3">{{ old('descricao', $post->descricao ?? '') }}</textarea>
    @error('descricao') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">URL da imagem</label>
    <input type="text" name="imagemurl" class="form-control @error('imagemurl') is-invalid @enderror"
           value="{{ old('imagemurl', $post->imagemurl ?? '') }}">
    @error('imagemurl') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Usuário autor</label>
    <select name="users_id" class="form-select @error('users_id') is-invalid @enderror">
        <option value="">Selecione...</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}"
                @selected(old('users_id', $post->users_id ?? '') == $user->id)>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
    @error('users_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Data encontrada</label>
        <input type="datetime-local" name="data_encontrada" class="form-control"
               value="{{ old('data_encontrada', isset($post) && $post->data_encontrada ? $post->data_encontrada->format('Y-m-d\TH:i') : '') }}">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Data devolvida</label>
        <input type="datetime-local" name="data_devolvida" class="form-control"
               value="{{ old('data_devolvida', isset($post) && $post->data_devolvida ? $post->data_devolvida->format('Y-m-d\TH:i') : '') }}">
    </div>
</div>