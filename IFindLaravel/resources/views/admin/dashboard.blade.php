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
      --if-green: #007A3D;
      --if-green-light: #00A651;
      --if-green-dim: #e8f5ee;
      --accent: #F5A623;
      --dark: #0D1F14;
      --sidebar-w: 240px;
      --sidebar-bg: #0D1F14;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: #f0f4f2;
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
      background: #fff;
      border-bottom: 1px solid #e2ebe5;
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
    <a href="{{ route('/') }}" class="sidebar-link">
      <i class="bi bi-eye-fill"></i> Ver Site Público
    </a>
    <div class="nav-section-label">Sistema</div>
    <a href="#" class="sidebar-link">
      <i class="bi bi-gear-fill"></i> Configurações
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
      {{-- @csrf --}}
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
          <div class="stat-value">48</div>
          <div class="stat-label">Total de Posts</div>
          <div class="stat-delta up"><i class="bi bi-arrow-up-short"></i> +6 esta semana</div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="stat-card">
          <div class="stat-icon" style="background:#e3f2fd;"><i class="bi bi-people-fill" style="color:#1565c0;"></i></div>
          <div class="stat-value">320</div>
          <div class="stat-label">Alunos cadastrados</div>
          <div class="stat-delta up"><i class="bi bi-arrow-up-short"></i> +12 este mês</div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="stat-card">
          <div class="stat-icon" style="background:#fff8e1;"><i class="bi bi-bag-check-fill" style="color:#e67e00;"></i></div>
          <div class="stat-value">87</div>
          <div class="stat-label">Itens devolvidos</div>
          <div class="stat-delta up"><i class="bi bi-arrow-up-short"></i> +3 esta semana</div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="stat-card">
          <div class="stat-icon" style="background:#fce4ec;"><i class="bi bi-archive-fill" style="color:#c62828;"></i></div>
          <div class="stat-value">13</div>
          <div class="stat-label">Posts ativos</div>
          <div class="stat-delta up"><i class="bi bi-arrow-up-short"></i> +2 hoje</div>
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
              <span class="badge ms-1" style="background:var(--if-green);font-size:.65rem;">48</span>
            </button>
          </li>
          <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabAlunos" role="tab">
              <i class="bi bi-people me-1"></i>Alunos
              <span class="badge ms-1" style="background:#1565c0;font-size:.65rem;">320</span>
            </button>
          </li>
        </ul>
        <input type="text" class="search-sm" placeholder="🔍  Buscar..." id="searchInput" oninput="filterTable()" />
      </div>

      <div class="tab-content">

        <!-- TAB POSTS -->
        <div class="tab-pane fade show active" id="tabPosts" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-hover" id="postsTable">
              <thead>
                <tr>
                  <th>Item</th>
                  <th>Tipo</th>
                  <th>Publicado por</th>
                  <th>Local</th>
                  <th>Data</th>
                  <th>Status</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><strong>Fone de ouvido preto</strong></td>
                  <td><span class="tag-tipo tag-achado">Achado</span></td>
                  <td>João Silva</td>
                  <td>Bloco B</td>
                  <td><small class="text-muted">há 2 horas</small></td>
                  <td><span class="badge bg-success" style="border-radius:6px;font-size:.72rem;">Ativo</span></td>
                  <td>
                    <div class="d-flex gap-1">
                      <button class="btn-action btn-resolve">Resolver</button>
                      <button class="btn-action btn-delete">Remover</button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><strong>Carteira marrom</strong></td>
                  <td><span class="tag-tipo tag-perdido">Perdido</span></td>
                  <td>Maria Souza</td>
                  <td>Refeitório</td>
                  <td><small class="text-muted">há 5 horas</small></td>
                  <td><span class="badge bg-success" style="border-radius:6px;font-size:.72rem;">Ativo</span></td>
                  <td>
                    <div class="d-flex gap-1">
                      <button class="btn-action btn-resolve">Resolver</button>
                      <button class="btn-action btn-delete">Remover</button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><strong>Chave com chaveiro azul</strong></td>
                  <td><span class="tag-tipo tag-achado">Achado</span></td>
                  <td>Carlos Lima</td>
                  <td>Bloco A</td>
                  <td><small class="text-muted">há 1 dia</small></td>
                  <td><span class="badge bg-success" style="border-radius:6px;font-size:.72rem;">Ativo</span></td>
                  <td>
                    <div class="d-flex gap-1">
                      <button class="btn-action btn-resolve">Resolver</button>
                      <button class="btn-action btn-delete">Remover</button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><strong>Mochila preta Quechua</strong></td>
                  <td><span class="tag-tipo tag-perdido">Perdido</span></td>
                  <td>Ana Costa</td>
                  <td>Sala 14</td>
                  <td><small class="text-muted">há 2 dias</small></td>
                  <td><span class="badge" style="border-radius:6px;font-size:.72rem;background:#1565c0;">Resolvido</span></td>
                  <td>
                    <button class="btn-action btn-delete">Remover</button>
                  </td>
                </tr>
                <tr>
                  <td><strong>Óculos de grau</strong></td>
                  <td><span class="tag-tipo tag-achado">Achado</span></td>
                  <td>Pedro Alves</td>
                  <td>Lab. Informática</td>
                  <td><small class="text-muted">há 3 dias</small></td>
                  <td><span class="badge bg-success" style="border-radius:6px;font-size:.72rem;">Ativo</span></td>
                  <td>
                    <div class="d-flex gap-1">
                      <button class="btn-action btn-resolve">Resolver</button>
                      <button class="btn-action btn-delete">Remover</button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><strong>Calculadora científica Casio</strong></td>
                  <td><span class="tag-tipo tag-perdido">Perdido</span></td>
                  <td>Luiza Ferreira</td>
                  <td>Bloco C</td>
                  <td><small class="text-muted">há 4 dias</small></td>
                  <td><span class="badge bg-success" style="border-radius:6px;font-size:.72rem;">Ativo</span></td>
                  <td>
                    <div class="d-flex gap-1">
                      <button class="btn-action btn-resolve">Resolver</button>
                      <button class="btn-action btn-delete">Remover</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="table-footer">
            <span style="font-size:.82rem;color:#aaa;">Mostrando 6 de 48 posts</span>
            <nav><ul class="pagination pagination-sm mb-0">
              <li class="page-item disabled"><a class="page-link" href="#">‹</a></li>
              <li class="page-item active"><a class="page-link" href="#" style="background:var(--if-green);border-color:var(--if-green);">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">›</a></li>
            </ul></nav>
          </div>
        </div>

        <!-- TAB ALUNOS -->
        <div class="tab-pane fade" id="tabAlunos" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-hover" id="alunosTable">
              <thead>
                <tr>
                  <th>Aluno</th>
                  <th>Matrícula</th>
                  <th>Turma / Curso</th>
                  <th>E-mail</th>
                  <th>Cadastrado em</th>
                  <th>Posts</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="user-avatar-sm" style="background:var(--if-green);">J</div>
                      <strong>João Silva</strong>
                    </div>
                  </td>
                  <td>2023001234</td>
                  <td>Informática 3° Ano</td>
                  <td><small>joao@email.com</small></td>
                  <td><small class="text-muted">há 2 horas</small></td>
                  <td><span class="badge" style="background:var(--if-green-dim);color:var(--if-green);font-size:.72rem;">3 posts</span></td>
                  <td><button class="btn-action btn-delete">Remover</button></td>
                </tr>
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="user-avatar-sm" style="background:#e67e00;">M</div>
                      <strong>Maria Souza</strong>
                    </div>
                  </td>
                  <td>2023005678</td>
                  <td>Elétrica 1° Ano</td>
                  <td><small>maria@email.com</small></td>
                  <td><small class="text-muted">há 5 horas</small></td>
                  <td><span class="badge" style="background:var(--if-green-dim);color:var(--if-green);font-size:.72rem;">1 post</span></td>
                  <td><button class="btn-action btn-delete">Remover</button></td>
                </tr>
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="user-avatar-sm" style="background:#1565c0;">C</div>
                      <strong>Carlos Lima</strong>
                    </div>
                  </td>
                  <td>2022009012</td>
                  <td>Mecânica 2° Ano</td>
                  <td><small>carlos@email.com</small></td>
                  <td><small class="text-muted">há 1 dia</small></td>
                  <td><span class="badge" style="background:var(--if-green-dim);color:var(--if-green);font-size:.72rem;">2 posts</span></td>
                  <td><button class="btn-action btn-delete">Remover</button></td>
                </tr>
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="user-avatar-sm" style="background:#6a1b9a;">A</div>
                      <strong>Ana Costa</strong>
                    </div>
                  </td>
                  <td>2023003456</td>
                  <td>Administração 2° Ano</td>
                  <td><small>ana@email.com</small></td>
                  <td><small class="text-muted">há 2 dias</small></td>
                  <td><span class="badge" style="background:var(--if-green-dim);color:var(--if-green);font-size:.72rem;">1 post</span></td>
                  <td><button class="btn-action btn-delete">Remover</button></td>
                </tr>
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="user-avatar-sm" style="background:#00796b;">P</div>
                      <strong>Pedro Alves</strong>
                    </div>
                  </td>
                  <td>2021007890</td>
                  <td>Informática 4° Ano</td>
                  <td><small>pedro@email.com</small></td>
                  <td><small class="text-muted">há 3 dias</small></td>
                  <td><span class="badge" style="background:var(--if-green-dim);color:var(--if-green);font-size:.72rem;">4 posts</span></td>
                  <td><button class="btn-action btn-delete">Remover</button></td>
                </tr>
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div class="user-avatar-sm" style="background:#c62828;">L</div>
                      <strong>Luiza Ferreira</strong>
                    </div>
                  </td>
                  <td>2023008901</td>
                  <td>Química 1° Ano</td>
                  <td><small>luiza@email.com</small></td>
                  <td><small class="text-muted">há 4 dias</small></td>
                  <td><span class="badge" style="background:var(--if-green-dim);color:var(--if-green);font-size:.72rem;">1 post</span></td>
                  <td><button class="btn-action btn-delete">Remover</button></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="table-footer">
            <span style="font-size:.82rem;color:#aaa;">Mostrando 6 de 320 alunos</span>
            <nav><ul class="pagination pagination-sm mb-0">
              <li class="page-item disabled"><a class="page-link" href="#">‹</a></li>
              <li class="page-item active"><a class="page-link" href="#" style="background:var(--if-green);border-color:var(--if-green);">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">›</a></li>
            </ul></nav>
          </div>
        </div>

      </div>
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

  document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
    tab.addEventListener('shown.bs.tab', () => {
      document.getElementById('searchInput').value = '';
      filterTable();
    });
  });
</script>
</body>
</html>
