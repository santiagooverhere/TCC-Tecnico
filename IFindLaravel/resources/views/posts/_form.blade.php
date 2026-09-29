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
    <label class="form-label">Imagem do item</label>
    @isset($post)
        @if ($post->imagemurl)
            <div class="mb-2">
                <img src="{{ $post->imagem_exibicao }}" alt="{{ $post->nome_item }}" style="max-height:120px;border-radius:8px;">
            </div>
        @endif
    @endisset
    <input type="file" name="imagem" accept="image/*" class="form-control @error('imagem') is-invalid @enderror">
    @error('imagem') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

@unless ($publico ?? false)
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
@endunless

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Data encontrada</label>
        <input type="datetime-local" name="data_encontrada" class="form-control"
               value="{{ old('data_encontrada', isset($post) && $post->data_encontrada ? $post->data_encontrada->format('Y-m-d\TH:i') : '') }}">
    </div>
    @unless ($publico ?? false)
    <div class="col-md-6 mb-3">
        <label class="form-label">Data devolvida</label>
        <input type="datetime-local" name="data_devolvida" class="form-control"
               value="{{ old('data_devolvida', isset($post) && $post->data_devolvida ? $post->data_devolvida->format('Y-m-d\TH:i') : '') }}">
    </div>
    @endunless
</div>
