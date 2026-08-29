<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>IFIND — Redefinir senha</title>
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
      max-width: 440px;
    }
    .form-card h3 {
      font-family: 'Sora', sans-serif;
      font-weight: 700;
      font-size: 1.4rem;
      color: var(--dark);
    }
    .form-card p.sub { color: #888; font-size: .9rem; margin-bottom: 28px; }
    .form-label { font-weight: 600; font-size: .85rem; color: #444; margin-bottom: 6px; }
    .form-control {
      border-radius: 10px;
      border: 1.5px solid #dde8e2;
      padding: 11px 14px;
      font-size: .95rem;
    }
    .form-control:focus {
      border-color: var(--if-green);
      box-shadow: 0 0 0 3px rgba(0,122,61,.1);
    }
    .btn-submit {
      background: var(--if-green);
      color: #fff;
      border-radius: 12px;
      font-weight: 700;
      font-size: 1rem;
      padding: 13px;
      width: 100%;
      border: none;
    }
    .btn-submit:hover { background: var(--if-green-light); color: #fff; }
    .brand {
      font-family: 'Sora', sans-serif;
      font-weight: 800;
      font-size: 1.6rem;
      color: var(--if-green);
      text-align: center;
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

    <h3>Criar nova senha</h3>
    <p class="sub">Escolha uma nova senha para sua conta.</p>

    @if ($errors->any())
      <div class="alert alert-danger py-2 small">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST">
      @csrf

      <input type="hidden" name="token" value="{{ $request->route('token') }}">

      <div class="mb-3">
        <label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" placeholder="seu@email.com"
               value="{{ old('email', $request->email) }}" required autofocus />
      </div>

      <div class="mb-3">
        <label class="form-label">Nova senha</label>
        <input type="password" name="password" class="form-control" placeholder="Mínimo 8 caracteres" required />
      </div>

      <div class="mb-4">
        <label class="form-label">Confirmar nova senha</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Repita a senha" required />
      </div>

      <button type="submit" class="btn-submit">
        <i class="bi bi-check-lg me-2"></i>Redefinir senha
      </button>
    </form>
  </div>

</body>
</html>
