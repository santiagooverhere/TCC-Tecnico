<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>IFIND — Cadastrar-se</title>
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
    }

    /* ── TOP BAR ──────────────────────────────────── */
    .topbar {
      background: #fff;
      border-bottom: 1px solid #e2ebe5;
      padding: 14px 0;
    }
    .brand {
      font-family: 'Sora', sans-serif;
      font-weight: 800;
      font-size: 1.5rem;
      color: var(--if-green);
      text-decoration: none;
    }
    .brand span { color: var(--accent); }

    /* ── PROGRESS STEPS ─────────────────────────── */
    .steps-bar {
      background: #fff;
      border-bottom: 1px solid #eef2ef;
      padding: 16px 0;
    }
    .step-item {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: .85rem;
      color: #aaa;
      font-weight: 500;
    }
    .step-item.active { color: var(--if-green); font-weight: 700; }
    .step-item.done { color: #aaa; }
    .step-circle {
      width: 30px; height: 30px;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-weight: 700;
      font-size: .85rem;
      background: #eee;
      color: #aaa;
      flex-shrink: 0;
    }
    .step-item.active .step-circle {
      background: var(--if-green);
      color: #fff;
    }
    .step-separator {
      flex: 1;
      height: 2px;
      background: #e2ebe5;
      margin: 0 8px;
    }

    /* ── FORM CARD ──────────────────────────────── */
    .form-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 8px 40px rgba(0,0,0,0.08);
      padding: 40px;
      max-width: 700px;
      margin: 0 auto;
    }
    .form-card h4 {
      font-family: 'Sora', sans-serif;
      font-weight: 700;
      font-size: 1.3rem;
      color: var(--dark);
    }
    .form-label {
      font-weight: 600;
      font-size: .85rem;
      color: #444;
      margin-bottom: 6px;
    }
    .form-control, .form-select {
      border-radius: 10px;
      border: 1.5px solid #dde8e2;
      padding: 11px 14px;
      font-size: .95rem;
      transition: border-color .2s, box-shadow .2s;
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--if-green);
      box-shadow: 0 0 0 3px rgba(0,122,61,.1);
    }
    .input-group .form-control { border-right: none; }
    .input-group .btn-eye {
      border: 1.5px solid #dde8e2;
      border-left: none;
      border-radius: 0 10px 10px 0;
      background: #fff; color: #aaa;
    }
    .input-group .btn-eye:hover { color: var(--if-green); }
    .form-text { font-size: .78rem; color: #999; margin-top: 4px; }

    /* Avatar upload */
    .avatar-upload {
      width: 90px; height: 90px;
      border-radius: 50%;
      background: var(--if-green-dim);
      border: 2px dashed var(--if-green);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: .7rem;
      color: var(--if-green);
      font-weight: 600;
      gap: 4px;
      transition: background .2s;
    }
    .avatar-upload:hover { background: #d4edde; }

    /* Password strength */
    .strength-bar {
      height: 4px;
      border-radius: 4px;
      background: #eee;
      margin-top: 8px;
      overflow: hidden;
    }
    .strength-fill {
      height: 100%;
      border-radius: 4px;
      width: 0;
      transition: width .3s, background .3s;
    }

    /* Buttons */
    .btn-submit {
      background: var(--if-green);
      color: #fff;
      border-radius: 12px;
      font-weight: 700;
      font-size: 1rem;
      padding: 13px 32px;
      border: none;
      transition: background .2s, transform .15s;
    }
    .btn-submit:hover {
      background: var(--if-green-light);
      transform: translateY(-1px);
      color: #fff;
    }
    .btn-back {
      background: #f4f7f5;
      color: #555;
      border-radius: 12px;
      font-weight: 600;
      font-size: .95rem;
      padding: 13px 24px;
      border: 1.5px solid #dde8e2;
    }

    /* Terms */
    .terms-box {
      background: #f9fbfa;
      border: 1.5px solid #e2ebe5;
      border-radius: 12px;
      padding: 14px 16px;
      font-size: .85rem;
      color: #555;
    }
    .terms-box a { color: var(--if-green); font-weight: 600; text-decoration: none; }

    @media (max-width: 576px) {
      .form-card { padding: 24px 18px; }
      .step-label { display: none; }
    }
  </style>
</head>
<body>

  <!-- TOPBAR -->
  <div class="topbar">
    <div class="container d-flex align-items-center justify-content-between">
      <a href="{{ route('/') }}" class="brand">IF<span>IND</span></a>
      <span style="font-size:.9rem; color:#888;">
        Já tem conta? <a href="{{ route('/login') }}" style="color:var(--if-green); font-weight:700; text-decoration:none;">Entrar</a>
      </span>
    </div>
  </div>

  <!-- STEPS -->
  <div class="steps-bar">
    <div class="container">
      <div class="d-flex align-items-center" style="max-width:580px; margin:0 auto;">
        <div class="step-item active">
          <div class="step-circle">1</div>
          <span class="step-label">Dados Pessoais</span>
        </div>
        <div class="step-separator"></div>
        <div class="step-item">
          <div class="step-circle">2</div>
          <span class="step-label">Conta</span>
        </div>
        <div class="step-separator"></div>
        <div class="step-item">
          <div class="step-circle">3</div>
          <span class="step-label">Confirmação</span>
        </div>
      </div>
    </div>
  </div>

  <!-- CONTENT -->
  <div class="container py-5">
    <div class="form-card">

      <div class="mb-4">
        <h4>Crie sua conta no IFIND</h4>
        <p style="color:#888; font-size:.9rem; margin:0;">Preencha os dados abaixo para se cadastrar. Levará menos de 2 minutos.</p>
      </div>

      <form action="/register" method="POST" enctype="multipart/form-data">
        <!-- @csrf -->

        <!-- FOTO -->
        <div class="d-flex align-items-center gap-3 mb-4">
          <div class="avatar-upload" onclick="document.getElementById('avatarInput').click()">
            <i class="bi bi-camera fs-4"></i>
            <span>Foto (opcional)</span>
          </div>
          <input type="file" id="avatarInput" name="avatar" accept="image/*" class="d-none" onchange="previewAvatar(this)" />
          <div style="font-size:.82rem; color:#999; line-height:1.6;">
            Adicione uma foto para que outros alunos<br />possam te identificar mais facilmente.
          </div>
        </div>

        <hr class="my-4" style="border-color:#eef2ef;" />
        <p class="fw-bold small text-uppercase text-muted mb-3">Informações pessoais</p>

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Nome</label>
            <input type="text" name="first_name" class="form-control" placeholder="João" required />
          </div>
          <div class="col-md-6">
            <label class="form-label">Sobrenome</label>
            <input type="text" name="last_name" class="form-control" placeholder="Silva" required />
          </div>
          <div class="col-md-6">
            <label class="form-label">Matrícula (opcional)</label>
            <input type="text" name="matricula" class="form-control" placeholder="Ex: 2023001234" />
            <div class="form-text">Número de matrícula no Instituto Federal.</div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Turma / Curso</label>
            <input type="text" name="turma" class="form-control" placeholder="Ex: Informática 3° Ano" />
          </div>
          <div class="col-12">
            <label class="form-label">Telefone / WhatsApp</label>
            <div class="input-group">
              <span class="input-group-text" style="border-radius:10px 0 0 10px; border:1.5px solid #dde8e2; border-right:none; background:#f9fbfa;">
                <i class="bi bi-whatsapp text-success"></i>
              </span>
              <input type="tel" name="phone" class="form-control" placeholder="(00) 00000-0000" style="border-left:none; border-radius: 0 10px 10px 0;" />
            </div>
            <div class="form-text">Usado para contato via WhatsApp nos posts. Não será exibido publicamente.</div>
          </div>
        </div>

        <hr class="my-4" style="border-color:#eef2ef;" />
        <p class="fw-bold small text-uppercase text-muted mb-3">Credenciais de acesso</p>

        <div class="row g-3">
          <div class="col-12">
            <label class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" placeholder="seu@email.com" required />
            <div class="form-text">Pode ser e-mail pessoal ou institucional.</div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Senha</label>
            <div class="input-group">
              <input type="password" name="password" id="pwdInput" class="form-control" placeholder="Mínimo 8 caracteres" required oninput="checkStrength(this.value)" />
              <button type="button" class="btn-eye px-3" onclick="togglePwd('pwdInput','eyeIcon1')">
                <i class="bi bi-eye" id="eyeIcon1"></i>
              </button>
            </div>
            <div class="strength-bar">
              <div class="strength-fill" id="strengthFill"></div>
            </div>
            <div class="form-text" id="strengthLabel">Digite uma senha forte.</div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Confirmar Senha</label>
            <div class="input-group">
              <input type="password" name="password_confirmation" id="pwdConfirm" class="form-control" placeholder="Repita a senha" required />
              <button type="button" class="btn-eye px-3" onclick="togglePwd('pwdConfirm','eyeIcon2')">
                <i class="bi bi-eye" id="eyeIcon2"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- TERMOS -->
        <div class="terms-box mt-4">
          <div class="form-check mb-0">
            <input class="form-check-input" type="checkbox" id="terms" name="terms" required />
            <label class="form-check-label" for="terms">
              Concordo com os <a href="#">Termos de Uso</a> e a <a href="#">Política de Privacidade</a> do IFIND. Entendo que meus dados serão usados exclusivamente para facilitar a devolução de pertences no campus.
            </label>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
          <a href="{{ route('/login') }}" class="btn btn-back">
            <i class="bi bi-arrow-left me-2"></i>Voltar
          </a>
          <button type="submit" class="btn-submit">
            Criar Conta <i class="bi bi-arrow-right ms-2"></i>
          </button>
        </div>
      </form>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function togglePwd(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon  = document.getElementById(iconId);
      input.type  = input.type === 'password' ? 'text' : 'password';
      icon.className = input.type === 'text' ? 'bi bi-eye-slash' : 'bi bi-eye';
    }

    function checkStrength(value) {
      const fill  = document.getElementById('strengthFill');
      const label = document.getElementById('strengthLabel');
      let score = 0;
      if (value.length >= 8) score++;
      if (/[A-Z]/.test(value)) score++;
      if (/[0-9]/.test(value)) score++;
      if (/[^A-Za-z0-9]/.test(value)) score++;
      const levels = [
        { pct: '0%',   color: '#eee',    text: 'Digite uma senha.' },
        { pct: '25%',  color: '#e53935', text: 'Senha fraca' },
        { pct: '50%',  color: '#fb8c00', text: 'Senha razoável' },
        { pct: '75%',  color: '#fdd835', text: 'Senha boa' },
        { pct: '100%', color: '#00A651', text: 'Senha forte ✓' },
      ];
      const l = levels[score];
      fill.style.width    = l.pct;
      fill.style.background = l.color;
      label.textContent   = l.text;
    }

    function previewAvatar(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        const box    = input.closest('.d-flex').querySelector('.avatar-upload');
        reader.onload = e => {
          box.style.backgroundImage   = `url(${e.target.result})`;
          box.style.backgroundSize    = 'cover';
          box.style.backgroundPosition = 'center';
          box.innerHTML = '';
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
</body>
</html>
