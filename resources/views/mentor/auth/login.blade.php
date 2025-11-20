<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Acesso Restrito - Mentores</title>
    <style>
        body { font-family: sans-serif; background: #1e293b; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 2rem; border-radius: 8px; width: 100%; max-width: 350px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #334155; margin-bottom: 1.5rem; font-size: 1.5rem; }
        label { display: block; margin-bottom: 0.5rem; color: #64748b; font-size: 0.9rem; }
        input { width: 100%; padding: 0.75rem; margin-bottom: 1rem; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 0.75rem; background: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        button:hover { background: #1d4ed8; }
        .error { color: #ef4444; font-size: 0.85rem; margin-bottom: 1rem; text-align: center; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Portal Mentores</h1>

        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('mentor.login.post') }}" method="POST">
            @csrf
            <label>E-mail Corporativo</label>
            <input type="email" name="email" required autofocus>

            <label>Senha de Acesso</label>
            <input type="password" name="password" required>

            <button type="submit">Acessar Painel</button>
        </form>
    </div>
</body>
</html>
