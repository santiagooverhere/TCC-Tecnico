<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>IFIND — Painel Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <style>
    :root {
      --if-green: #00663a;
      --if-green-light: #0c6838;
      --if-green-dim: #e8f5ee;
      --accent: #d5ff7b;
      --dark: #079000;
      --sidebar-w: 240px;
      --sidebar-bg: #0D1F14;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: #41574c;
      min-height: 100vh;
    }

    /* ── SIDEBAR ─────────────────────────────────── */
    .sidebar {
      width: var(--sidebar-w);
      background: var(--sidebar-bg);
      min-height: 100vh;
      position: fixed;
      top: 0; left: 0;
      display: flex;
      flex-direction: column;
      z-index: 100;
    }
    .sidebar-brand {
      padding: 24px 20px 20px;
      border-bottom: 1px solid rgba(255,255,255,.08);
    }
    .sidebar-brand .brand-txt {
      font-family: 'Sora', sans-serif;
      font-weight: 800;
      font-size: 1.5rem;
      color: #fff;
    }
    .sidebar-brand .brand-txt span { color: var(--accent); }
    .sidebar-brand .badge-admin {
      background: rgba(245,166,35,.15);
      color: var(--accent);
      font-size: .65rem;
      font-weight: 700;
      letter-spacing: 1px;
      border-radius: 4px;
      padding: 2px 8px;
      text-transform: uppercase;
    }

    .sidebar-nav { flex: 1; padding: 16px 12px; }
    .nav-section-label {
      font-size: .65rem;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: rgba(255,255,255,.3);
      padding: 16px 8px 6px;
    }
    .sidebar-link {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 12px;
      border-radius: 10px;
      color: rgba(255,255,255,.6);
      text-decoration: none;
      font-size: .9rem;
      font-weight: 500;
      transition: background .2s, color .2s;
      margin-bottom: 2px;
    }
    .sidebar-link i { font-size: 1rem; width: 20px; text-align: center; }
    .sidebar-link:hover { background: rgba(255,255,255,.08); color: #fff; }
    .sidebar-link.active { background: var(--if-green); color: #fff; }

    .sidebar-footer {
      padding: 16px;
      border-top: 1px solid rgba(255,255,255,.08);
    }
    .admin-info { display: flex; align-items: center; gap: 10px; }
    .admin-avatar {
      width: 36px; height: 36px;
      background: var(--if-green);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; color: #fff; font-size: .9rem;
      flex-shrink: 0;
    }
    .admin-name { font-size: .85rem; color: #fff; font-weight: 600; line-height: 1.2; }
    .admin-role { font-size: .72rem; color: rgba(255,255,255,.4); }

    /* ── MAIN ────────────────────────────────────── */
    .main-content {
      margin-left: var(--sidebar-w);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* TOP BAR */
    .topbar {
      background: #002801;
      border-bottom: 1px solid #000000;
      padding: 14px 28px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky; top: 0; z-index: 50;
    }
    .topbar-title { font-family: 'Sora', sans-serif; font-weight: 700; font-size: 1.1rem; color: var(--dark); }
    .topbar-subtitle { font-size: .8rem; color: #888; }
    .btn-logout {
      background: #f4f7f5;
      border: 1.5px solid #dde8e2;
      color: #666;
      border-radius: 10px;
      font-size: .85rem;
      font-weight: 600;
      padding: 7px 16px;
      transition: background .2s;
      cursor: pointer;
    }
    .btn-logout:hover { background: #ffe8e8; border-color: #f5b5b5; color: #c0392b; }

    /* CONTENT AREA */
    .content-area { padding: 28px; flex: 1; }

    /* ── STAT CARDS ─────────────────────────────── */
    .stat-card {
      background: #fff;
      border-radius: 16px;
      padding: 22px 20px;
      box-shadow: 0 4px 20px rgba(0,0,0,.05);
    }
    .stat-card .stat-icon {
      width: 48px; height: 48px;
      border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.4rem;
      margin-bottom: 14px;
    }
    .stat-card .stat-value {
      font-family: 'Sora', sans-serif;
      font-weight: 800; font-size: 2rem;
      color: var(--dark); line-height: 1;
    }
    .stat-card .stat-label { font-size: .85rem; color: #888; margin-top: 4px; }
    .stat-card .stat-delta { font-size: .75rem; font-weight: 600; margin-top: 6px; }
    .stat-card .stat-delta.up { color: var(--if-green); }

    /* ── TABLE CARD ─────────────────────────────── */
    .table-card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,.05);
      overflow: hidden;
    }
    .table { margin: 0; }
    .table thead th {
      background: #f9fbfa;
      font-size: .78rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .5px;
      color: #888;
      border-bottom: 1px solid #eef2ef;
      padding: 12px 18px;
      white-space: nowrap;
    }
    .table tbody td {
      padding: 13px 18px;
      font-size: .88rem;
      vertical-align: middle;
      border-bottom: 1px solid #f5f8f6;
      color: #333;
    }
    .table tbody tr:last-child td { border-bottom: none; }
    .table tbody tr:hover { background: #fafcfb; }

    .tag-tipo {
      font-size: .72rem; font-weight: 700;
      border-radius: 8px; padding: 3px 10px;
      text-transform: uppercase; letter-spacing: .4px;
      white-space: nowrap;
    }
    .tag-achado  { background: #e8f5ee; color: var(--if-green); }
    .tag-perdido { background: #fff3e0; color: #e67e00; }

    .btn-action {
      font-size: .78rem; font-weight: 600;
      border-radius: 7px; padding: 4px 12px;
      border: 1.5px solid; white-space: nowrap;
      cursor: pointer; background: #fff;
      transition: background .15s, color .15s;
    }
    .btn-resolve { border-color: var(--if-green); color: var(--if-green); }
    .btn-resolve:hover { background: var(--if-green); color: #fff; }
    .btn-delete  { border-color: #e74c3c; color: #e74c3c; }
    .btn-delete:hover  { background: #e74c3c; color: #fff; }

    /* User avatar pequeno na tabela */
    .user-avatar-sm {
      width: 32px; height: 32px;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; color: #fff; font-size: .8rem;
      flex-shrink: 0;
    }

    /* Tabs */
    .admin-tabs {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 10px;
      padding: 0 20px;
      border-bottom: 2px solid #eef2ef;
    }
    .admin-tabs .nav { flex-wrap: nowrap; }
    .admin-tabs .nav-link {
      border: none;
      border-bottom: 2px solid transparent;
      margin-bottom: -2px;
      font-size: .88rem; font-weight: 600;
      color: #888; padding: 14px 16px;
      border-radius: 0; background: none;
    }
    .admin-tabs .nav-link.active {
      color: var(--if-green);
      border-bottom-color: var(--if-green);
    }
    .search-sm {
      border-radius: 8px;
      border: 1.5px solid #dde8e2;
      font-size: .82rem;
      padding: 7px 12px;
      width: 190px;
    }
    .search-sm:focus { outline: none; border-color: var(--if-green); box-shadow: 0 0 0 3px rgba(0,122,61,.08); }

    /* Paginação footer */
    .table-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px 20px;
      border-top: 1px solid #f0f5f2;
    }

    /* Mobile */
    .sidebar-overlay { display: none; }
    @media (max-width: 991px) {
      .sidebar { transform: translateX(-100%); transition: transform .3s; }
      .sidebar.open { transform: translateX(0); }
      .sidebar-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.4); z-index: 99; }
      .sidebar-overlay.show { display: block; }
      .main-content { margin-left: 0; }
      .topbar { padding: 12px 16px; }
      .content-area { padding: 16px; }
      .search-sm { width: 140px; }
    }
  </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-brand">
    <div class="brand-txt">IF<span>IND</span></div>
    <div class="badge-admin mt-1">Admin</div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section-label">Visão Geral</div>
    <a href="#" class="sidebar-link active">
      <i class="bi bi-grid-fill"></i> Dashboard
    </a>
    <a href="{{ route('dashboard') }}" class="sidebar-link">
      <i class="bi bi-eye-fill"></i> Ver Site Público
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="admin-info">
      <div class="admin-avatar">A</div>
      <div>
        <div class="admin-name">Admin IFIND</div>
        <div class="admin-role">Administrador</div>
      </div>
    </div>
  </div>
</aside>

<!-- MAIN -->
<div class="main-content">

  <!-- TOPBAR -->
  <div class="topbar">
    <div class="d-flex align-items-center gap-3">
      <button class="btn btn-sm d-lg-none" style="background:none;border:none;" onclick="toggleSidebar()">
        <i class="bi bi-list fs-4"></i>
      </button>
      <div>
        <div class="topbar-title">Dashboard</div>
        <div class="topbar-subtitle">Bem-vindo, Admin · <span id="dateNow"></span></div>
      </div>
    </div>
    <form action="/logout" method="POST">
      @csrf
      <button type="submit" class="btn-logout">
        <i class="bi bi-box-arrow-right me-1"></i>Sair
      </button>
    </form>
  </div>

  <!-- CONTENT -->
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

          <!-- Modais de edição de Posts (um por item, fora da tabela) -->
          @foreach ($posts as $post)
          <div class="modal fade" id="modalEditarPost{{ $post->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="{{ route('posts.update', $post) }}" method="POST">
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
                      <button type="button" class="btn-action btn-resolve" data-bs-toggle="modal" data-bs-target="#modalEditarAluno{{ $user->id }}">Editar</button>
                      <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Remover este aluno?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete">Remover</button>
                      </form>
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
                  <td>{{ $comentario->post->titulo ?? '—' }}</td>
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
      <form action="{{ route('posts.store') }}" method="POST">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('dateNow').textContent = new Date().toLocaleDateString('pt-BR', {
    weekday: 'long', day: 'numeric', month: 'long'
  });

  function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('show');
  }

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
</script>
</body>
</html>
