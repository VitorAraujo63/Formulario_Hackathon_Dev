<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Mentores - HackHealth</title>
    <style>
        /* Reset e Fontes */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            padding: 2rem;
        }

        /* Layout Principal */
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 1.5rem;
            color: #111827;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
        }

        /* Botões */
        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 0.375rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background-color 0.2s;
        }

        .btn-primary { background-color: #2563eb; color: white; }
        .btn-primary:hover { background-color: #1d4ed8; }

        .btn-success { background-color: #10B981; color: white; }
        .btn-success:hover { background-color: #059669; }

        .btn-outline { background-color: white; border: 1px solid #d1d5db; color: #374151; }
        .btn-outline:hover { background-color: #f9fafb; }

        /* Tabela */
        .table-container {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        thead {
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            padding: 1rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
            font-weight: 600;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.875rem;
        }

        tr:last-child td { border-bottom: none; }
        tr:hover { background-color: #f9fafb; }

        /* Tags de Disponibilidade */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 600;
            background-color: #e0e7ff;
            color: #3730a3;
            margin: 0.1rem;
        }

        /* Modal de Upload (Simples) */
        .upload-section {
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            border: 2px dashed #e5e7eb;
            display: none; /* Escondido por padrão */
        }

        .upload-section.active { display: block; }

        .upload-form {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        input[type="file"] {
            font-size: 0.875rem;
        }

        /* Mensagens */
        .alert {
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }
        .alert-success { background-color: #d1fae5; color: #065f46; }
        .alert-error { background-color: #fee2e2; color: #991b1b; }

    </style>
</head>
<body>

<div class="container">

    {{-- Feedback de Sucesso/Erro --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error">
            <ul style="list-style: none;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Header --}}
    <div class="header">
        <div>
            <h1>Gestão de Mentores</h1>
            <p style="color: #6b7280; font-size: 0.9rem;">Total de cadastros: <strong>{{ $mentores->count() }}</strong></p>
        </div>
        <div class="header-actions">
            <button class="btn btn-outline">
                <a href="{{ route('hackathon.mentor.inscricoes') }}" class="btn btn-success" style="background:#222">
                Alunos Inscritos
                </a>
            </button>
            <button class="btn btn-outline" onclick="toggleUpload()">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Importar Excel
            </button>
            <a href="{{ route('hackathon.mentor.export') }}" class="btn btn-success">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Exportar Excel
            </a>
        </div>
    </div>

    {{-- Seção de Upload (Toggle) --}}
    <div id="uploadSection" class="upload-section">
        <h3 style="margin-bottom: 1rem; font-size: 1rem;">Importar Mentores em Massa</h3>
        <form action="{{ route('hackathon.mentor.import') }}" method="POST" enctype="multipart/form-data" class="upload-form">
            @csrf
            <input type="file" name="arquivo_excel" required accept=".xlsx, .xls">
            <button type="submit" class="btn btn-primary">Enviar Arquivo</button>
            <span style="font-size: 0.8rem; color: #6b7280;">O Excel deve conter colunas: Nome, RG, Instituição, Especialidade, Disponibilidade.</span>
        </form>
    </div>

    {{-- Tabela de Listagem --}}
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Instituição / Especialidade</th>
                    <th>Disponibilidade</th>
                    <th>Data Cadastro</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mentores as $mentor)
                    <tr>
                        <td style="color: #6b7280;">#{{ $mentor->id }}</td>
                        <td>
                            <div style="font-weight: 600;">{{ $mentor->nome }}</div>
                            <div style="font-size: 0.8rem; color: #6b7280;">RG: {{ $mentor->rg }}</div>
                        </td>
                        <td>
                            <div>{{ $mentor->instituicao }}</div>
                            <div style="font-size: 0.8rem; color: #2563eb;">{{ $mentor->especialidade }}</div>
                        </td>
                        <td style="max-width: 300px;">
                            @if(is_array($mentor->disponibilidade))
                                @foreach($mentor->disponibilidade as $disp)
                                    <span class="badge">{{ str_replace('_', ' ', ucfirst($disp)) }}</span>
                                @endforeach
                            @else
                                <span style="color: #9ca3af;">-</span>
                            @endif
                        </td>
                        <td>{{ $mentor->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 2rem; color: #6b7280;">
                            Nenhum mentor cadastrado ainda.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
    function toggleUpload() {
        const el = document.getElementById('uploadSection');
        el.classList.toggle('active');
    }
</script>

</body>
</html>
