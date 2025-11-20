<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Inscrições - HackHealth</title>
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

        .header-stats {
            font-size: 0.9rem;
            color: #6b7280;
            margin-top: 0.25rem;
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

        .btn-success { background-color: #10B981; color: white; }
        .btn-success:hover { background-color: #059669; }

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

        /* Badges (Etiquetas) */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-blue { background-color: #e0e7ff; color: #3730a3; }
        .badge-green { background-color: #d1fae5; color: #065f46; }
        .badge-yellow { background-color: #fef3c7; color: #92400e; }
        .badge-gray { background-color: #f3f4f6; color: #1f2937; }

    </style>
</head>
<body>

<div class="container">

    {{-- Header --}}
    <div class="header">
        <div>
            <h1>Dashboard de Inscrições</h1>
            <p class="header-stats">Total de inscritos: <strong>{{ $submissions->count() }}</strong></p>
        </div>
        <div class="header-actions">
            <a href="{{ route('hackathon.mentor.index') }}" class="btn btn-success" style="background:#222">
                Mentores
            </a>
        </div>
        <div class="header-actions">
            <a href="{{ route('hackathon.mentor.export') }}" class="btn btn-success">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Baixar Excel (.xlsx)
            </a>
        </div>
    </div>

    {{-- Tabela de Listagem --}}
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Candidato</th>
                    <th>Área / Nível</th>
                    <th>Scores (F/M/D)</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($submissions as $sub)
                    <tr>
                        <td style="color: #6b7280; white-space: nowrap;">
                            {{ $sub->created_at->format('d/m/Y') }}<br>
                            <small>{{ $sub->created_at->format('H:i') }}</small>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #111827;">{{ $sub->nome }}</div>
                            <div style="font-size: 0.8rem; color: #6b7280;">{{ $sub->email }}</div>
                        </td>
                        <td>
                            <div style="margin-bottom: 4px;">
                                <span class="badge badge-blue">{{ $sub->selected_area }}</span>
                            </div>
                            <div>
                                <span class="badge {{ $sub->calculated_level == 'Iniciante' ? 'badge-gray' : ($sub->calculated_level == 'Avançado' ? 'badge-green' : 'badge-yellow') }}">
                                    {{ $sub->calculated_level }}
                                </span>
                            </div>
                        </td>
                        <td>
                            {{-- Exibe F/M/D de forma compacta --}}
                            <span title="Fácil">{{ $sub->score_facil }}</span> /
                            <span title="Médio">{{ $sub->score_medio }}</span> /
                            <span title="Difícil">{{ $sub->score_dificil }}</span>
                        </td>
                        <td>
                            <strong style="font-size: 1rem;">{{ $sub->score_total }}</strong>/6
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 2rem; color: #6b7280;">
                            Nenhuma inscrição realizada ainda.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
