@extends('layouts.painel-admin')

@section('content')
  <div class="content-area">

    <!-- STAT CARDS -->
    <div class="row g-3 mb-4">
      <div class="col-6 col-lg-3">
        <div class="stat-card">
          <div class="stat-icon" style="background:#e8f5ee;"><i class="bi bi-collection-fill text-success"></i></div>
          <div class="stat-value">{{ $totalPosts }}</div>
          <div class="stat-label">Total de Posts</div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="stat-card">
          <div class="stat-icon" style="background:#e3f2fd;"><i class="bi bi-people-fill" style="color:#1565c0;"></i></div>
          <div class="stat-value">{{ $totalUsers }}</div>
          <div class="stat-label">Alunos cadastrados</div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="stat-card">
          <div class="stat-icon" style="background:#fff8e1;"><i class="bi bi-bag-check-fill" style="color:#e67e00;"></i></div>
          <div class="stat-value">{{ $totalDevolvidos }}</div>
          <div class="stat-label">Itens devolvidos</div>
        </div>
      </div>
    </div>

    <!-- TABELA COM TABS -->
    <div class="table-card">

      <!-- Header com tabs e busca -->
      <div class="admin-tabs">
        <ul class="nav" id="adminTabs" role="tablist">
          <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabPosts" role="tab">
              <i class="bi bi-collection me-1"></i>Posts
              <span class="badge ms-1" style="background:var(--if-green);font-size:.65rem;">{{ $totalPosts }}</span>
            </button>
          </li>
          <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabAlunos" role="tab">
              <i class="bi bi-people me-1"></i>Alunos
              <span class="badge ms-1" style="background:#1565c0;font-size:.65rem;">{{ $totalUsers }}</span>
            </button>
          </li>
          <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabComentarios" role="tab">
              <i class="bi bi-chat-left-text me-1"></i>Comentários
              <span class="badge ms-1" style="background:#6a1b9a;font-size:.65rem;">{{ $totalComentarios }}</span>
            </button>
          </li>
        </ul>
        <div class="d-flex align-items-center gap-2">
          <input type="text" class="search-sm" placeholder="🔍  Buscar..." id="searchInput" oninput="filterTable()" />

          <button type="button" class="btn btn-success btn-sm tab-new-btn" data-tab="tabPosts" data-bs-toggle="modal" data-bs-target="#modalNovoPost">
            <i class="bi bi-plus-lg"></i> Novo Post
          </button>
          <button type="button" class="btn btn-success btn-sm tab-new-btn d-none" data-tab="tabAlunos" data-bs-toggle="modal" data-bs-target="#modalNovoAluno">
            <i class="bi bi-plus-lg"></i> Novo Aluno
          </button>
          <button type="button" class="btn btn-success btn-sm tab-new-btn d-none" data-tab="tabComentarios" data-bs-toggle="modal" data-bs-target="#modalNovoComentario">
            <i class="bi bi-plus-lg"></i> Novo Comentário
          </button>
        </div>
      </div>

      <div class="tab-content">

        <!-- TAB POSTS -->
        <div class="tab-pane fade show active" id="tabPosts" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-hover" id="postsTable">
              <thead>
                <tr>
                  <th>Item</th>
                  <th>Status</th>
                  <th>Publicado por</th>
                  <th>Data</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($posts as $post)
                <tr>
                  <td><strong>{{ $post->nome_item }}</strong></td>
                  <td>
                    @if ($post->data_devolvida)
                      <span class="tag-tipo" style="background:#e3f2fd;color:#1565c0;">Devolvido</span>
                    @else
                      <span class="tag-tipo tag-perdido">Perdido</span>
                    @endif
                  </td>
                  <td>{{ $post->user->name ?? '—' }}</td>
                  <td><small class="text-muted">{{ $post->created_at->diffForHumans() }}</small></td>
                  <td>
                    <div class="d-flex gap-1">
                      @if (!$post->data_devolvida)
                        <form action="{{ route('posts.resolver', $post) }}" method="POST">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="btn-action btn-resolve">Resolver</button>
                        </form>
                      @endif
                      <button type="button" class="btn-action btn-resolve" data-bs-toggle="modal" data-bs-target="#modalEditarPost{{ $post->id }}">Editar</button>
                      <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Remover este post?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete">Remover</button>
                      </form>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">Nenhum post cadastrado ainda.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="table-footer">
            <span style="font-size:.82rem;color:#aaa;">
              Mostrando {{ $posts->count() }} de {{ $posts->total() }} posts
            </span>
            {{ $posts->links() }}
          </div>

          <!-- Modais de edição de Posts -->
          @foreach ($posts as $post)
          <div class="modal fade" id="modalEditarPost{{ $post->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="_modal_target" value="modalEditarPost{{ $post->id }}">
                  <div class="modal-header">
                    <h5 class="modal-title">Editar Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    @include('posts._form', ['users' => $allUsers])
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar alterações</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          @endforeach
        </div>

        <!-- TAB ALUNOS -->
        <div class="tab-pane fade" id="tabAlunos" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-hover" id="alunosTable">
              <thead>
                <tr>
                  <th>Aluno</th>
                  <th>E-mail</th>
                  <th>Cadastrado em</th>
                  <th>Posts</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($users as $user)
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="user-avatar-sm" style="background:var(--if-green);">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                      <strong>{{ $user->name }}</strong>
                    </div>
                  </td>
                  <td><small>{{ $user->email }}</small></td>
                  <td><small class="text-muted">{{ $user->created_at->diffForHumans() }}</small></td>
                  <td><span class="badge" style="background:var(--if-green-dim);color:var(--if-green);font-size:.72rem;">{{ $user->posts_count }} {{ Str::plural('post', $user->posts_count) }}</span></td>
                  <td>
                    <div class="d-flex gap-1">
                      @if ($user->is_admin)
                        <span class="badge" style="background:#6a1b9a;font-size:.72rem;">Administrador</span>
                      @else
                        <button type="button" class="btn-action btn-resolve" data-bs-toggle="modal" data-bs-target="#modalEditarAluno{{ $user->id }}">Editar</button>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Remover este aluno?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn-action btn-delete">Remover</button>
                        </form>
                      @endif
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">Nenhum aluno cadastrado ainda.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="table-footer">
            <span style="font-size:.82rem;color:#aaa;">
              Mostrando {{ $users->count() }} de {{ $users->total() }} alunos
            </span>
            {{ $users->links() }}
          </div>

          @foreach ($users as $user)
          @continue($user->is_admin)
          <div class="modal fade" id="modalEditarAluno{{ $user->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="{{ route('users.update', $user) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="_modal_target" value="modalEditarAluno{{ $user->id }}">
                  <div class="modal-header">
                    <h5 class="modal-title">Editar Aluno</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    @include('users._form')
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar alterações</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          @endforeach
        </div>

        <!-- TAB COMENTÁRIOS -->
        <div class="tab-pane fade" id="tabComentarios" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-hover" id="comentariosTable">
              <thead>
                <tr>
                  <th>Usuário</th>
                  <th>Post</th>
                  <th>Nome exibido</th>
                  <th>Texto</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($comentarios as $comentario)
                <tr>
                  <td>{{ $comentario->user->name ?? '—' }}</td>
                  <td>{{ $comentario->post->nome_item ?? '—' }}</td>
                  <td>{{ $comentario->name_user }}</td>
                  <td>{{ Str::limit($comentario->texto, 50) }}</td>
                  <td>
                    <div class="d-flex gap-1">
                      <button type="button" class="btn-action btn-resolve" data-bs-toggle="modal" data-bs-target="#modalEditarComentario{{ $comentario->id }}">Editar</button>
                      <form action="{{ route('comentarios.destroy', $comentario) }}" method="POST" onsubmit="return confirm('Remover este comentário?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete">Remover</button>
                      </form>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">Nenhum comentário cadastrado ainda.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="table-footer">
            <span style="font-size:.82rem;color:#aaa;">
              Mostrando {{ $comentarios->count() }} de {{ $comentarios->total() }} comentários
            </span>
            {{ $comentarios->links() }}
          </div>

       
          @foreach ($comentarios as $comentario)
          <div class="modal fade" id="modalEditarComentario{{ $comentario->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="{{ route('comentarios.update', $comentario) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="_modal_target" value="modalEditarComentario{{ $comentario->id }}">
                  <div class="modal-header">
                    <h5 class="modal-title">Editar Comentário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    @include('comentarios._form')
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar alterações</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          @endforeach
        </div>

      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="modalNovoPost" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_modal_target" value="modalNovoPost">
        <div class="modal-header">
          <h5 class="modal-title">Novo Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          @include('posts._form', ['users' => $allUsers])
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="modalNovoAluno" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <input type="hidden" name="_modal_target" value="modalNovoAluno">
        <div class="modal-header">
          <h5 class="modal-title">Novo Aluno</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          @include('users._form')
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="modalNovoComentario" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('comentarios.store') }}" method="POST">
        @csrf
        <input type="hidden" name="_modal_target" value="modalNovoComentario">
        <div class="modal-header">
          <h5 class="modal-title">Novo Comentário</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          @include('comentarios._form', ['users' => $allUsers, 'posts' => $allPosts])
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
  function filterTable() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    const activePane = document.querySelector('.tab-pane.show.active');
    activePane.querySelectorAll('tbody tr').forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
  }


  function updateNewButton(tabId) {
    document.querySelectorAll('.tab-new-btn').forEach(btn => {
      btn.classList.toggle('d-none', btn.dataset.tab !== tabId);
    });
  }


  document.getElementById('adminTabs').addEventListener('click', (event) => {
    const tabBtn = event.target.closest('[data-bs-toggle="tab"]');
    if (!tabBtn) return;
    const targetId = tabBtn.getAttribute('data-bs-target').replace('#', '');
    updateNewButton(targetId);
  });

  document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
    tab.addEventListener('shown.bs.tab', () => {
      document.getElementById('searchInput').value = '';
      filterTable();
    });
  });


  updateNewButton('tabPosts');


  @if ($errors->any())
    (function () {
      const modalId = @json(old('_modal_target'));
      if (!modalId) return;

      const modalEl = document.getElementById(modalId);
      if (!modalEl) return;

  
      let tabId = null;
      if (modalId.includes('Post'))       tabId = 'tabPosts';
      else if (modalId.includes('Aluno')) tabId = 'tabAlunos';
      else if (modalId.includes('Comentario')) tabId = 'tabComentarios';

      if (tabId) {
        const tabButton = document.querySelector(`[data-bs-target="#${tabId}"]`);
        if (tabButton) new bootstrap.Tab(tabButton).show();
      }

      new bootstrap.Modal(modalEl).show();
    })();
  @endif
@endpush
