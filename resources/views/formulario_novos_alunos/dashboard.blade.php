@extends('layouts.app')

@section('title', 'Admin | Dashboard Nonos Alunos')

@section('content')

<div class="container" style="padding: 40px 20px; max-width: 1200px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="font-size: 24px; color: #333; font-weight: bold;">Dashboard - Novos Alunos</h1>

        <a href="{{ route('admin.alunos.export') }}" style="background: #217346; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: flex; align-items: center; gap: 8px; font-weight: 500;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="8" y1="13" x2="16" y2="13"></line>
                <line x1="8" y1="17" x2="16" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            Baixe as planilhas de Novos Alunos
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px;">

        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #007bff;">
            <h3 style="margin: 0; color: #888; font-size: 14px;">Total de Inscritos</h3>
            <p style="margin: 10px 0 0; font-size: 32px; font-weight: bold; color: #333;">{{ $totalAlunos }}</p>
        </div>

        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #28a745;">
            <h3 style="margin: 0; color: #888; font-size: 14px;">Alunos com Conhecimento</h3>
            <p style="margin: 10px 0 0; font-size: 32px; font-weight: bold; color: #333;">{{ $totalComConhecimento }}</p>
        </div>

        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #ffc107;">
            <h3 style="margin: 0; color: #888; font-size: 14px;">Última Inscrição</h3>
            <p style="margin: 10px 0 0; font-size: 24px; font-weight: bold; color: #333;">{{ $ultimoInscrito }}</p>
        </div>
    </div>

    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background-color: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                <tr>
                    <th style="padding: 15px; text-align: left; color: #555;">Nome do Aluno</th>
                    <th style="padding: 15px; text-align: left; color: #555;">Série</th>
                    <th style="padding: 15px; text-align: left; color: #555;">Responsável</th>
                    <th style="padding: 15px; text-align: left; color: #555;">Contato Responsável</th>
                    <th style="padding: 15px; text-align: left; color: #555;">Conhecimento?</th>
                    <th style="padding: 15px; text-align: left; color: #555;">Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alunos as $aluno)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px; font-weight: bold;">{{ $aluno->nome_completo }}</td>

                    <td style="padding: 15px;">
                        {{ str_replace(['_ano', '_em'], ['º Ano', 'ª Série'], $aluno->serie) }}
                    </td>

                    <td style="padding: 15px;">{{ $aluno->nome_responsavel }}</td>

                    <td style="padding: 15px;">
                        <a href="https://wa.me/55{{ preg_replace('/\D/', '', $aluno->telefone_responsavel) }}" target="_blank" style="color: #28a745; text-decoration: none; font-weight: 500;">
                            {{ $aluno->telefone_responsavel }}
                        </a>
                    </td>

                    <td style="padding: 15px;">
                        @if($aluno->tem_conhecimento_previo)
                            <span style="background: #d4edda; color: #155724; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">Sim</span>
                        @else
                            <span style="background: #f8d7da; color: #721c24; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">Não</span>
                        @endif
                    </td>

                    <td style="padding: 15px; color: #777; font-size: 14px;">
                        {{ $aluno->created_at->format('d/m/Y') }}
                    </td>
                </tr>
                @endforeach

                @if($alunos->isEmpty())
                <tr>
                    <td colspan="6" style="padding: 40px; text-align: center; color: #999;">
                        Nenhum aluno inscrito ainda.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
