<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>IFIND — Achados e Perdidos</title>
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
      --text-muted-custom: #6c7a72;
      --card-radius: 16px;
      --shadow: 0 4px 24px rgba(0,0,0,0.07);
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: #f4f7f5;
      color: var(--dark);
    }

    /* ── NAVBAR ─────────────────────────────────── */
    .navbar {
      background: #fff;
      border-bottom: 1px solid #e2ebe5;
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
      background: #f4f7f5;
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

    .btn-whatsapp {
      background: #25D366;
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
    .btn-whatsapp:hover { background: #1ebe5d; color: #fff; }

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
        <ul class="navbar-nav me-auto ms-3 gap-1">
          <li class="nav-item"><a class="nav-link active" href="#">Início</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Achados</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Perdidos</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Sobre</a></li>
        </ul>
        <div class="d-flex gap-2">
          <a href="{{ route('/register') }}" class="btn btn-outline-secondary rounded-3" style="font-weight:600; font-size:.9rem;">Cadastrar-se</a>
          <a href="{{ route('/login') }}" class="btn btn-login">Entrar</a>
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
              <span style="font-size:.9rem;">87 itens devolvidos</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SEARCH BAR -->
  <div class="container search-bar-wrapper mb-4">
    <div class="search-card">
      <div class="row g-2 align-items-end">
        <div class="col-12 col-md-5">
          <label class="form-label fw-600 small mb-1">Buscar item</label>
          <input type="text" class="form-control" placeholder="Ex: carteira, fone, chave..." />
        </div>
        <div class="col-6 col-md-3">
          <label class="form-label fw-600 small mb-1">Categoria</label>
          <select class="form-select">
            <option value="">Todas</option>
            <option>Eletrônicos</option>
            <option>Documentos</option>
            <option>Roupas e Acessórios</option>
            <option>Chaves</option>
            <option>Outros</option>
          </select>
        </div>
        <div class="col-6 col-md-2">
          <label class="form-label fw-600 small mb-1">Tipo</label>
          <select class="form-select">
            <option value="">Todos</option>
            <option>Achado</option>
            <option>Perdido</option>
          </select>
        </div>
        <div class="col-12 col-md-2">
          <button class="btn btn-search w-100">
            <i class="bi bi-search me-1"></i> Buscar
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- MAIN CONTENT -->
  <div class="container pb-5">

    <!-- Aviso para não logados -->
    <div class="login-notice mb-4 d-flex align-items-center gap-3">
      <i class="bi bi-info-circle-fill fs-4 text-success"></i>
      <div>
        <strong>Você está navegando sem login.</strong>
        <span class="text-muted ms-1 d-none d-sm-inline">Para publicar um item ou comentar, </span>
        <a href="{{ route('/login') }}" class="text-success fw-bold">faça login</a> ou <a href="{{ route('/register') }}" class="text-success fw-bold">cadastre-se gratuitamente</a>.
      </div>
    </div>

    <!-- Feed de posts -->
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div class="d-flex align-items-center gap-2">
        <span class="section-title">Publicações recentes</span>
        <span class="badge-count">48 itens</span>
      </div>
      <select class="form-select form-select-sm w-auto" style="border-radius:8px;">
        <option>Mais recentes</option>
        <option>Mais antigos</option>
      </select>
    </div>

    <div class="row g-4">
      <!-- Card 1 -->
      <div class="col-sm-6 col-lg-4 col-xl-3">
        <div class="item-card card">
          <img src="https://placehold.co/400x200/e8f5ee/007A3D?text=Foto+do+Item" alt="Item achado" />
          <div class="card-body">
            <span class="tag-tipo tag-achado mb-2 d-inline-block"><i class="bi bi-check-circle-fill me-1"></i>Achado</span>
            <h6 class="card-title">Fone de ouvido preto</h6>
            <p class="card-text">Encontrado próximo à biblioteca, bloco B. Sem capa protetora.</p>
          </div>
          <div class="card-footer">
            <div>
              <div class="meta-info"><i class="bi bi-geo-alt"></i> Bloco B</div>
              <div class="meta-info mt-1"><i class="bi bi-clock"></i> há 2 horas</div>
            </div>
            <a href="https://wa.me/?text=Encontrei+esse+item+no+IFIND" target="_blank" class="btn-whatsapp">
              <i class="bi bi-whatsapp"></i> Contato
            </a>
          </div>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-sm-6 col-lg-4 col-xl-3">
        <div class="item-card card">
          <img src="https://placehold.co/400x200/fff3e0/e67e00?text=Foto+do+Item" alt="Item perdido" />
          <div class="card-body">
            <span class="tag-tipo tag-perdido mb-2 d-inline-block"><i class="bi bi-exclamation-circle-fill me-1"></i>Perdido</span>
            <h6 class="card-title">Carteira marrom</h6>
            <p class="card-text">Perdi no refeitório na hora do almoço. Contém documentos importantes.</p>
          </div>
          <div class="card-footer">
            <div>
              <div class="meta-info"><i class="bi bi-geo-alt"></i> Refeitório</div>
              <div class="meta-info mt-1"><i class="bi bi-clock"></i> há 5 horas</div>
            </div>
            <a href="https://wa.me/?text=Vi+esse+item+no+IFIND" target="_blank" class="btn-whatsapp">
              <i class="bi bi-whatsapp"></i> Contato
            </a>
          </div>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-sm-6 col-lg-4 col-xl-3">
        <div class="item-card card">
          <img src="https://placehold.co/400x200/e8f5ee/007A3D?text=Foto+do+Item" alt="Item achado" />
          <div class="card-body">
            <span class="tag-tipo tag-achado mb-2 d-inline-block"><i class="bi bi-check-circle-fill me-1"></i>Achado</span>
            <h6 class="card-title">Chave com chaveiro azul</h6>
            <p class="card-text">Achada no corredor do bloco de salas de aula, térreo.</p>
          </div>
          <div class="card-footer">
            <div>
              <div class="meta-info"><i class="bi bi-geo-alt"></i> Bloco A</div>
              <div class="meta-info mt-1"><i class="bi bi-clock"></i> há 1 dia</div>
            </div>
            <a href="https://wa.me/?text=Vi+esse+item+no+IFIND" target="_blank" class="btn-whatsapp">
              <i class="bi bi-whatsapp"></i> Contato
            </a>
          </div>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="col-sm-6 col-lg-4 col-xl-3">
        <div class="item-card card">
          <img src="https://placehold.co/400x200/fff3e0/e67e00?text=Foto+do+Item" alt="Item perdido" />
          <div class="card-body">
            <span class="tag-tipo tag-perdido mb-2 d-inline-block"><i class="bi bi-exclamation-circle-fill me-1"></i>Perdido</span>
            <h6 class="card-title">Mochila preta Quechua</h6>
            <p class="card-text">Esquecida na sala 14 no final da tarde. Tem cadernos e um estojo roxo.</p>
          </div>
          <div class="card-footer">
            <div>
              <div class="meta-info"><i class="bi bi-geo-alt"></i> Sala 14</div>
              <div class="meta-info mt-1"><i class="bi bi-clock"></i> há 2 dias</div>
            </div>
            <a href="https://wa.me/?text=Vi+esse+item+no+IFIND" target="_blank" class="btn-whatsapp">
              <i class="bi bi-whatsapp"></i> Contato
            </a>
          </div>
        </div>
      </div>

      <!-- Card 5 -->
      <div class="col-sm-6 col-lg-4 col-xl-3">
        <div class="item-card card">
          <img src="https://placehold.co/400x200/e8f5ee/007A3D?text=Foto+do+Item" alt="Item achado" />
          <div class="card-body">
            <span class="tag-tipo tag-achado mb-2 d-inline-block"><i class="bi bi-check-circle-fill me-1"></i>Achado</span>
            <h6 class="card-title">Óculos de grau</h6>
            <p class="card-text">Encontrado no laboratório de informática. Armação preta fina.</p>
          </div>
          <div class="card-footer">
            <div>
              <div class="meta-info"><i class="bi bi-geo-alt"></i> Lab. Informática</div>
              <div class="meta-info mt-1"><i class="bi bi-clock"></i> há 3 dias</div>
            </div>
            <a href="https://wa.me/?text=Vi+esse+item+no+IFIND" target="_blank" class="btn-whatsapp">
              <i class="bi bi-whatsapp"></i> Contato
            </a>
          </div>
        </div>
      </div>

      <!-- Card 6 -->
      <div class="col-sm-6 col-lg-4 col-xl-3">
        <div class="item-card card">
          <img src="https://placehold.co/400x200/fff3e0/e67e00?text=Foto+do+Item" alt="Item perdido" />
          <div class="card-body">
            <span class="tag-tipo tag-perdido mb-2 d-inline-block"><i class="bi bi-exclamation-circle-fill me-1"></i>Perdido</span>
            <h6 class="card-title">Calculadora científica</h6>
            <p class="card-text">Casio FX-82MS. Sumiu depois da aula de matemática, bloco C.</p>
          </div>
          <div class="card-footer">
            <div>
              <div class="meta-info"><i class="bi bi-geo-alt"></i> Bloco C</div>
              <div class="meta-info mt-1"><i class="bi bi-clock"></i> há 4 dias</div>
            </div>
            <a href="https://wa.me/?text=Vi+esse+item+no+IFIND" target="_blank" class="btn-whatsapp">
              <i class="bi bi-whatsapp"></i> Contato
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Paginação -->
    <div class="d-flex justify-content-center mt-5">
      <nav>
        <ul class="pagination">
          <li class="page-item disabled"><a class="page-link" href="#">‹</a></li>
          <li class="page-item active"><a class="page-link" href="#" style="background:var(--if-green); border-color:var(--if-green);">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">›</a></li>
        </ul>
      </nav>
    </div>
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
          <small>© 2025 IFIND · Todos os direitos reservados</small>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
