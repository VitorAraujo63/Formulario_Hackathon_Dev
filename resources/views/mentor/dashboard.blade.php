<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Área do Mentor</title>
    <style>
        body { font-family: system-ui, sans-serif; background: #f1f5f9; padding: 2rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .welcome { font-size: 1.25rem; font-weight: bold; color: #0f172a; }
        .btn-logout { color: #ef4444; text-decoration: none; font-weight: 600; border: 1px solid #ef4444; padding: 0.5rem 1rem; border-radius: 4px; }

        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; }
        .card { background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); text-decoration: none; color: inherit; transition: transform 0.2s; border-left: 4px solid transparent; }
        .card:hover { transform: translateY(-3px); border-left-color: #2563eb; }
        .card h3 { margin: 0 0 0.5rem 0; color: #1e293b; }
        .card p { margin: 0; color: #64748b; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="header">
        <div class="welcome">
            Olá, {{ Auth::guard('mentor')->user()->nome }}
            <span style="font-size:0.8em; font-weight:normal; color:#64748b;">({{ Auth::guard('mentor')->user()->funcao }})</span>
        </div>
        <a href="{{ route('mentor.logout') }}" class="btn-logout">Sair</a>
    </div>

    <div class="grid">
        <a href="{{ route('hackathon.mentor.index') }}" class="card">
            <h3>Gerenciar Mentores</h3>
            <p>Visualize e cadastre novos mentores para o evento.</p>
        </a>

        <a href="{{ route('hackathon.mentor.inscricoes') }}" class="card">
            <h3>Inscrições Hackathon</h3>
            <p>Acompanhe os participantes inscritos e notas.</p>
        </a>

        <a href="{{ route('hackathon.mentor.export') }}" class="card">
            <h3>Relatórios</h3>
            <p>Baixe as planilhas de mentores.</p>
        </a>

        <a href="{{ route('hackathon.inscricoes.export') }}" class="card">
            <h3>Excel Inscrições</h3>
            <p>Baixe as planilhas de participantes.</p>
        </a>
    </div>
</body>
</html>
