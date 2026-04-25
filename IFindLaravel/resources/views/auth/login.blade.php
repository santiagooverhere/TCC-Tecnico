<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>IFIND — Entrar</title>
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
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: #f4f7f5;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* ── SPLIT LAYOUT ────────────────────────────── */
    .auth-wrapper {
      flex: 1;
      display: flex;
      min-height: 100vh;
    }

    .auth-left {
      width: 45%;
      background: linear-gradient(160deg, var(--if-green) 0%, #004d26 100%);
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 60px 56px;
      position: relative;
      overflow: hidden;
    }
    .auth-left::before {
      content: '';
      position: absolute;
      top: -80px; right: -80px;
      width: 280px; height: 280px;
      border-radius: 50%;
      background: rgba(255,255,255,.05);
    }
    .auth-left::after {
      content: '';
      position: absolute;
      bottom: -60px; left: -60px;
      width: 200px; height: 200px;
      border-radius: 50%;
      background: rgba(255,255,255,.04);
    }
    .auth-left .brand {
      font-family: 'Sora', sans-serif;
      font-weight: 800;
      font-size: 2rem;
      color: #fff;
      letter-spacing: -1px;
      margin-bottom: 40px;
    }
    .auth-left .brand span { color: var(--accent); }
    .auth-left h2 {
      font-family: 'Sora', sans-serif;
      font-weight: 700;
      color: #fff;
      font-size: 1.7rem;
      line-height: 1.3;
    }
    .auth-left p {
      color: rgba(255,255,255,.7);
      margin-top: 12px;
      font-size: .95rem;
    }
    .feature-item {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-top: 20px;
      color: rgba(255,255,255,.85);
      font-size: .9rem;
    }
    .feature-icon {
      width: 36px; height: 36px;
      background: rgba(255,255,255,.12);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1rem;
      flex-shrink: 0;
    }

    .auth-right {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 24px;
    }

    /* ── FORM CARD ──────────────────────────────── */
    .form-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 8px 40px rgba(0,0,0,0.08);
      padding: 44px 40px;
      width: 100%;
      max-width: 420px;
    }
    .form-card h3 {
      font-family: 'Sora', sans-serif;
      font-weight: 700;
      font-size: 1.5rem;
      color: var(--dark);
    }
    .form-card p.sub { color: #888; font-size: .9rem; margin-bottom: 28px; }

    .form-label {
      font-weight: 600;
      font-size: .85rem;
      color: #444;
      margin-bottom: 6px;
    }
    .form-control {
      border-radius: 10px;
      border: 1.5px solid #dde8e2;
      padding: 11px 14px;
      font-size: .95rem;
      transition: border-color .2s, box-shadow .2s;
    }
    .form-control:focus {
      border-color: var(--if-green);
      box-shadow: 0 0 0 3px rgba(0,122,61,.1);
    }
    .input-group .form-control { border-right: none; }
    .input-group .btn-eye {
      border: 1.5px solid #dde8e2;
      border-left: none;
      border-radius: 0 10px 10px 0;
      background: #fff;
      color: #aaa;
      cursor: pointer;
    }
    .input-group .btn-eye:hover { color: var(--if-green); }

    .btn-submit {
      background: var(--if-green);
      color: #fff;
      border-radius: 12px;
      font-weight: 700;
      font-size: 1rem;
      padding: 13px;
      width: 100%;
      border: none;
      transition: background .2s, transform .15s;
    }
    .btn-submit:hover {
      background: var(--if-green-light);
      transform: translateY(-1px);
      color: #fff;
    }

    .divider { position: relative; text-align: center; margin: 20px 0; }
    .divider::before {
      content: '';
      position: absolute;
      top: 50%; left: 0; right: 0;
      height: 1px;
      background: #eee;
    }
    .divider span {
      background: #fff;
      padding: 0 12px;
      font-size: .8rem;
      color: #aaa;
      position: relative;
    }

    .alert-admin {
      background: #fff8e1;
      border: 1px solid #ffe082;
      border-radius: 10px;
      padding: 12px 16px;
      font-size: .85rem;
      color: #795548;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .auth-left { display: none; }
      .form-card { padding: 32px 24px; }
    }
  </style>
</head>
<body>

  <div class="auth-wrapper">

    <!-- LEFT PANEL -->
    <div class="auth-left d-none d-md-flex">
      <div class="brand">IF<span>IND</span></div>
      <h2>Bem-vindo de<br />volta ao campus!</h2>
      <p>Acesse sua conta para publicar itens, comentar nas postagens e se conectar com a comunidade.</p>

      <div class="mt-4">
        <div class="feature-item">
          <div class="feature-icon"><i class="bi bi-bell-fill text-warning"></i></div>
          <span>Notificações em tempo real de novos itens</span>
        </div>
        <div class="feature-item">
          <div class="feature-icon"><i class="bi bi-chat-dots-fill text-info"></i></div>
          <span>Comente e ajude outros alunos</span>
        </div>
        <div class="feature-item">
          <div class="feature-icon"><i class="bi bi-shield-check-fill" style="color:var(--accent)"></i></div>
          <span>Acesso ao painel administrativo</span>
        </div>
      </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="auth-right">
      <div class="form-card">

        <!-- Mobile brand -->
        <div class="d-md-none text-center mb-4">
          <span style="font-family:'Sora',sans-serif; font-weight:800; font-size:1.8rem; color:var(--if-green);">IF<span style="color:var(--accent)">IND</span></span>
        </div>

        <h3>Entrar na conta</h3>
        <p class="sub">Use o e-mail institucional ou pessoal cadastrado.</p>

        <form action="/login" method="POST">
          <!-- CSRF placeholder for Laravel -->
          <!-- @csrf -->

          <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" placeholder="seu@email.com" required />
          </div>

          <div class="mb-2">
            <label class="form-label">Senha</label>
            <div class="input-group">
              <input type="password" name="password" id="passwordInput" class="form-control" placeholder="••••••••" required />
              <button type="button" class="btn-eye px-3" onclick="togglePass()">
                <i class="bi bi-eye" id="eyeIcon"></i>
              </button>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="remember" name="remember" />
              <label class="form-check-label" for="remember" style="font-size:.85rem;">Lembrar-me</label>
            </div>
            <a href="#" style="font-size:.85rem; color:var(--if-green); font-weight:600; text-decoration:none;">Esqueci a senha</a>
          </div>

          <!-- Aviso admin -->
          <div class="alert-admin mb-4">
            <i class="bi bi-shield-exclamation me-1"></i>
            <strong>Administrador?</strong> Após o login, seu perfil será verificado automaticamente e você terá acesso ao painel de gestão.
          </div>

          <button type="submit" class="btn-submit">
            <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
          </button>
        </form>

        <div class="divider"><span>ou</span></div>

        <div class="text-center" style="font-size:.9rem;">
          Não tem conta?
          <a href="{{ route('/register') }}" style="color:var(--if-green); font-weight:700; text-decoration:none;">Cadastre-se grátis</a>
        </div>

        <div class="text-center mt-3">
          <a href="{{ route('/') }}" style="color:#aaa; font-size:.85rem; text-decoration:none;">
            <i class="bi bi-arrow-left me-1"></i>Voltar ao início
          </a>
        </div>

      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function togglePass() {
      const input = document.getElementById('passwordInput');
      const icon  = document.getElementById('eyeIcon');
      if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
      } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
      }
    }
  </script>
</body>
</html>
