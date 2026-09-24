<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>IFIND — Achados e Perdidos</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
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
      --text-muted-custom: #6c7a72;
      --card-radius: 16px;
      --shadow: 0 4px 24px rgba(0,0,0,0.07);
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: #1b4f2b;
      color: var(--dark);
    }

    /* ── NAVBAR ─────────────────────────────────── */
    .navbar {
      background: #000000;
      border-bottom: 1px solid #000000;
      padding: 14px 0;
      box-shadow: 0 2px 12px rgba(0,122,61,0.06);
    }
    .navbar-brand {
      font-family: 'Sora', sans-serif;
      font-weight: 800;
      font-size: 1.5rem;
      color: var(--if-green) !important;
      letter-spacing: -0.5px;
    }
    .navbar-brand span {
      color: var(--accent);
    }
    .nav-link {
      font-weight: 500;
      color: #444 !important;
      transition: color .2s;
    }
    .nav-link:hover { color: var(--if-green) !important; }
    .btn-login {
      background: var(--if-green);
      color: #fff;
      border-radius: 10px;
      font-weight: 600;
      padding: 8px 22px;
      font-size: .9rem;
      transition: background .2s, transform .15s;
    }
    .btn-login:hover {
      background: var(--if-green-light);
      color: #fff;
      transform: translateY(-1px);
    }

    /* ── HERO ────────────────────────────────────── */
    .hero {
      background: linear-gradient(135deg, var(--if-green) 0%, #005c2e 100%);
      color: #fff;
      padding: 64px 0 48px;
      position: relative;
      overflow: hidden;
    }
    .hero::after {
      content: '';
      position: absolute;
      bottom: -1px; left: 0; right: 0;
      height: 40px;
      background: #005f13;
      clip-path: ellipse(55% 100% at 50% 100%);
    }
    .hero h1 {
      font-family: 'Sora', sans-serif;
      font-weight: 800;
      font-size: 2.4rem;
      line-height: 1.2;
    }
    .hero h1 span { color: var(--accent); }
    .hero p { opacity: .85; font-size: 1.05rem; max-width: 520px; }

    /* ── SEARCH BAR ──────────────────────────────── */
    .search-bar-wrapper {
      margin-top: -24px;
      position: relative;
      z-index: 10;
    }
    .search-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.10);
      padding: 20px 24px;
    }
    .search-card .form-control {
      border-radius: 10px;
      border: 1.5px solid #dde8e2;
      padding: 10px 16px;
      font-size: .95rem;
    }
    .search-card .form-control:focus {
      border-color: var(--if-green);
      box-shadow: 0 0 0 3px rgba(0,122,61,.12);
    }
    .search-card .form-select {
      border-radius: 10px;
      border: 1.5px solid #dde8e2;
      font-size: .95rem;
    }
    .btn-search {
      background: var(--if-green);
      color: #fff;
      border-radius: 10px;
      font-weight: 600;
      padding: 10px 28px;
      transition: background .2s;
    }
    .btn-search:hover { background: var(--if-green-light); color: #fff; }

    /* ── SECTION TITLE ──────────────────────────── */
    .section-title {
      font-family: 'Sora', sans-serif;
      font-weight: 700;
      font-size: 1.3rem;
      color: var(--dark);
    }
    .badge-count {
      background: var(--if-green-dim);
      color: var(--if-green);
      font-weight: 700;
      border-radius: 20px;
      font-size: .8rem;
      padding: 3px 12px;
    }

    /* ── ITEM CARD ──────────────────────────────── */
    .item-card {
      background: #fff;
      border-radius: var(--card-radius);
      box-shadow: var(--shadow);
      border: none;
      overflow: hidden;
      transition: transform .2s, box-shadow .2s;
      height: 100%;
    }
    .item-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 36px rgba(0,0,0,0.12);
    }
    .item-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }
    .item-card .card-body { padding: 16px 18px; }
    .item-card .card-title {
      font-family: 'Sora', sans-serif;
      font-weight: 700;
      font-size: 1rem;
      margin-bottom: 6px;
    }
    .item-card .card-text {
      font-size: .85rem;
      color: var(--text-muted-custom);
      line-height: 1.5;
    }
    .item-card .card-footer {
      background: #fff;
      border-top: 1px solid #f0f5f2;
      padding: 12px 18px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .tag-tipo {
      font-size: .72rem;
      font-weight: 700;
      border-radius: 8px;
      padding: 3px 10px;
      letter-spacing: .5px;
      text-transform: uppercase;
    }
    .tag-achado { background: #e8f5ee; color: var(--if-green); }
    .tag-perdido { background: #fff3e0; color: #e67e00; }

    .btn-gmail {
      background: #EA4335;
      color: #fff;
      border-radius: 8px;
      font-size: .8rem;
      font-weight: 600;
      padding: 5px 12px;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 5px;
      transition: background .2s;
    }
    .btn-gmail:hover { background: #c5321a; color: #fff; }

    .meta-info {
      font-size: .75rem;
      color: #aaa;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    /* ── AVISO LOGIN ────────────────────────────── */
    .login-notice {
      background: linear-gradient(90deg, var(--if-green-dim), #fff);
      border-left: 4px solid var(--if-green);
      border-radius: 12px;
      padding: 16px 20px;
    }

    /* ── FOOTER ─────────────────────────────────── */
    footer {
      background: var(--dark);
      color: #ccc;
      padding: 32px 0;
      margin-top: 60px;
    }
    footer .brand {
      font-family: 'Sora', sans-serif;
      font-weight: 800;
      font-size: 1.3rem;
      color: #fff;
    }
    footer .brand span { color: var(--accent); }
    footer a { color: #aaa; text-decoration: none; font-size: .9rem; }
    footer a:hover { color: var(--accent); }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand" href="#">IF<span>IND</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <div class="d-flex gap-2">
          @guest
            <a href="{{ route('register') }}" class="btn btn-outline-secondary rounded-3" style="font-weight:600; font-size:.9rem;">Cadastrar-se</a>
            <a href="{{ route('login') }}" class="btn btn-login">Entrar</a>
          @else
            @if (auth()->user()->is_admin)
              <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-3" style="font-weight:600; font-size:.9rem;">Painel Admin</a>
            @endif
            <form action="{{ route('logout') }}" method="POST" class="m-0">
              @csrf
              <button type="submit" class="btn btn-login">Sair</button>
            </form>
          @endguest
        </div>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <section class="hero">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-7">
          <h1>Perdeu algo no campus?<br>A gente te <span>ajuda a achar.</span></h1>
          <p class="mt-3">O IFIND é a plataforma colaborativa de achados e perdidos do Instituto Federal. Rápido, digital e feito pela comunidade.</p>
          <div class="d-flex gap-3 mt-4 flex-wrap">
            <div class="d-flex align-items-center gap-2 text-white-50">
              <i class="bi bi-people-fill fs-5 text-white"></i>
              <span style="font-size:.9rem;">+320 alunos cadastrados</span>
            </div>
            <div class="d-flex align-items-center gap-2 text-white-50">
              <i class="bi bi-bag-check-fill fs-5 text-white"></i>
              <span style="font-size:.9rem;">{{ $totalDevolvidos }} {{ Str::plural('item devolvido', $totalDevolvidos) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SEARCH BAR -->
  <div class="container search-bar-wrapper mb-4">
    <div class="search-card">
      <form action="{{ route('dashboard') }}" method="GET">
        <div class="row g-2 align-items-end">
          <div class="col-12 col-md-7">
            <label class="form-label fw-600 small mb-1">Buscar item</label>
            <input type="text" name="busca" class="form-control" placeholder="Ex: carteira, fone, chave..."
                   value="{{ request('busca') }}" />
          </div>
          <div class="col-6 col-md-3">
            <label class="form-label fw-600 small mb-1">Tipo</label>
            <select name="tipo" class="form-select">
              <option value="" @selected(request('tipo') === null || request('tipo') === '')>Todos</option>
              <option value="achado" @selected(request('tipo') === 'achado')>Achado</option>
              <option value="devolvido" @selected(request('tipo') === 'devolvido')>Devolvido</option>
            </select>
          </div>
          <div class="col-6 col-md-2">
            <button type="submit" class="btn btn-search w-100">
              <i class="bi bi-search me-1"></i> Buscar
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- MAIN CONTENT -->
  <div class="container pb-5">

    <!-- Aviso para não logados -->
    @guest
      <div class="login-notice mb-4 d-flex align-items-center gap-3">
        <i class="bi bi-info-circle-fill fs-4 text-success"></i>
        <div>
          <strong>Você está navegando sem login.</strong>
          <span class="text-muted ms-1 d-none d-sm-inline">Para publicar um item</span>
          <a href="{{ route('login') }}" class="text-success fw-bold">faça login</a> ou <a href="{{ route('register') }}" class="text-success fw-bold">cadastre-se gratuitamente</a>.
        </div>
      </div>
    @endguest

    <!-- Feed de posts -->
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div class="d-flex align-items-center gap-2">
        <span class="section-title">Publicações recentes</span>
        <span class="badge-count">{{ $totalPosts }} {{ Str::plural('item', $totalPosts) }}</span>
      </div>
    </div>

    <div class="row g-4">
      @forelse ($posts as $post)
        <div class="col-sm-6 col-lg-4 col-xl-3">
          <div class="item-card card">
            <img src="{{ $post->imagem_exibicao }}" alt="{{ $post->nome_item }}" />
            <div class="card-body">
              @if ($post->data_devolvida)
                <span class="tag-tipo tag-achado mb-2 d-inline-block"><i class="bi bi-check-circle-fill me-1"></i>Devolvido</span>
              @else
                <span class="tag-tipo tag-perdido mb-2 d-inline-block"><i class="bi bi-exclamation-circle-fill me-1"></i>Achado</span>
              @endif
              <h6 class="card-title">{{ $post->nome_item }}</h6>
              <p class="card-text">{{ Str::limit($post->descricao ?? '', 90) ?: 'Sem descrição.' }}</p>
            </div>
            <div class="card-footer">
              <div>
                <div class="meta-info"><i class="bi bi-clock"></i> {{ $post->data_encontrada?->diffForHumans() ?? '—' }}</div>
              </div>
              @if ($post->user && $post->user->email)
                <a href="https://mail.google.com/mail/u/0/?view=cm&fs=1&to={{ urlencode($post->user->email) }}&su={{ urlencode('IFIND - Sobre o item: ' . $post->nome_item) }}&body={{ urlencode("Olá! Vi seu post sobre \"{$post->nome_item}\" no IFIND e gostaria de falar sobre isso.") }}&tf=cm"
                   target="_blank" class="btn-gmail">
                  <i class="bi bi-envelope-fill"></i> Contato
                </a>
              @endif
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="text-center text-white-50 py-5">
            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
            Nenhum item encontrado.
          </div>
        </div>
      @endforelse
    </div>

    <!-- Paginação -->
    @if ($posts->hasPages())
      <div class="d-flex justify-content-center mt-5">
        {{ $posts->links() }}
      </div>
    @endif
  </div>

  <!-- FOOTER -->
  <footer>
    <div class="container">
      <div class="row gy-3 align-items-center">
        <div class="col-md-4">
          <div class="brand mb-1">IF<span>IND</span></div>
          <small>Achados e Perdidos · Instituto Federal</small>
        </div>
        <div class="col-md-4 text-md-center">
          <small>Dúvidas? Fale com a administração</small><br />
          <a href="mailto:ifind@ifmg.edu.br">ifind@ifmg.edu.br</a>
        </div>
        <div class="col-md-4 text-md-end">
          <small>© 2026 IFIND · Todos os direitos reservados</small>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
