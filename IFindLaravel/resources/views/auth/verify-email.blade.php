<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>IFIND — Verifique seu e-mail</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <style>
    :root {
      --if-green: #00663a;
      --if-green-light: #0c6838;
      --accent: #d5ff7b;
      --dark: #079000;
    }
    body {
      font-family: 'DM Sans', sans-serif;
      background: #1b4f2b;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
    }
    .form-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 8px 40px rgba(0,0,0,0.08);
      padding: 44px 40px;
      width: 100%;
      max-width: 460px;
      text-align: center;
    }
    .icon-wrap {
      width: 72px; height: 72px;
      background: #e8f5ee;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 20px;
      font-size: 1.8rem;
      color: var(--if-green);
    }
    .form-card h3 {
      font-family: 'Sora', sans-serif;
      font-weight: 700;
      font-size: 1.4rem;
      color: var(--dark);
    }
    .form-card p.sub { color: #888; font-size: .92rem; margin-bottom: 24px; line-height: 1.6; }
    .btn-submit {
      background: var(--if-green);
      color: #fff;
      border-radius: 12px;
      font-weight: 700;
      font-size: .95rem;
      padding: 12px;
      width: 100%;
      border: none;
    }
    .btn-submit:hover { background: var(--if-green-light); color: #fff; }
    .brand {
      font-family: 'Sora', sans-serif;
      font-weight: 800;
      font-size: 1.6rem;
      color: var(--if-green);
      display: block;
      margin-bottom: 24px;
      text-decoration: none;
    }
    .brand span { color: var(--accent); background: var(--if-green); padding: 0 4px; border-radius: 4px; }
  </style>
</head>
<body>

  <div class="form-card">
    <a href="{{ route('dashboard') }}" class="brand">IF<span>IND</span></a>

    <div class="icon-wrap"><i class="bi bi-envelope-check"></i></div>

    <h3>Confirme seu e-mail</h3>
    <p class="sub">
      Enviamos um link de confirmação para o seu e-mail. Clique nele para
      ativar sua conta e começar a usar o IFIND.
    </p>

    @if (session('status') == 'verification-link-sent')
      <div class="alert alert-success py-2 small">
        Um novo link de verificação foi enviado para o seu e-mail!
      </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
      @csrf
      <button type="submit" class="btn-submit">
        <i class="bi bi-arrow-repeat me-2"></i>Reenviar e-mail de verificação
      </button>
    </form>

    <div class="mt-3">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-link" style="color:#aaa; font-size:.85rem; text-decoration:none;">
          Sair
        </button>
      </form>
    </div>
  </div>

</body>
</html>
