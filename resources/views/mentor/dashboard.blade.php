@extends('layouts.mentor')

@section('title', 'Visão Geral')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">

    {{-- 1. SAUDAÇÃO E DATA --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">
                Olá, {{ Auth::guard('mentor')->user()->nome ?? 'Mentor' }}! 👋
            </h1>
            <p class="text-slate-500 mt-1">
                Resumo das atividades hoje, <span class="font-bold text-slate-700 capitalize">{{ now()->translatedFormat('l, d \d\e F') }}</span>.
            </p>
        </div>

        {{-- Botão de Ação Rápida (Criar Chamada) --}}
        <a href="{{ route('admin.chamada.index') }}" class="bg-white border border-slate-200 text-slate-600 px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-50 hover:text-blue-600 transition shadow-sm flex items-center gap-2">
            <i class="fas fa-plus-circle"></i> Nova Chamada
        </a>
    </div>

    {{-- 2. ALERTAS E CHAMADA ATIVA --}}
    @if(isset($chamadaAtiva) && $chamadaAtiva)
    <div class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-700 shadow-xl shadow-blue-200 text-white p-6 flex flex-col md:flex-row items-center justify-between gap-6">

        {{-- Decorativo --}}
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>

        <div class="flex items-center gap-4 z-10">
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm animate-pulse">
                <i class="fas fa-satellite-dish text-xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg leading-tight">Aula em Andamento</h3>
                <p class="text-blue-100 text-sm mt-1">
                    Mentor: <span class="font-bold">{{ $chamadaAtiva->mentor->nome ?? 'Desconhecido' }}</span> •
                    Sala: <span class="font-mono font-bold bg-white/10 px-2 py-0.5 rounded">{{ $chamadaAtiva->codigo_acesso }}</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.chamada.painel', $chamadaAtiva->id) }}" class="z-10 bg-white text-blue-700 px-6 py-3 rounded-xl font-bold shadow-sm hover:bg-blue-50 transition transform hover:scale-105 flex items-center gap-2">
            Acessar Painel <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    @endif

    {{-- 3. CARDS DE ESTATÍSTICAS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Card 1 --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Alunos</p>
                <h4 class="text-2xl font-black text-slate-800">{{ $totalAlunos ?? 0 }}</h4>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
            <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Presença Média</p>
                <h4 class="text-2xl font-black text-slate-800">{{ $presencaMedia ?? 0 }}%</h4>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Mentores</p>
                <h4 class="text-2xl font-black text-slate-800">{{ $totalMentores ?? 0 }}</h4>
            </div>
        </div>

        {{-- Card 4 (Acesso Rápido) --}}
        <div class="bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-700 flex flex-col justify-center text-white">
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-3">Atalhos</p>
            <div class="flex gap-2">
                <a href="{{ route('admin.alunos.index') }}" class="flex-1 bg-white/10 hover:bg-white/20 p-2 rounded-lg text-center transition">
                    <i class="fas fa-plus block text-sm mb-1"></i>
                    <span class="text-xs font-bold">Aluno</span>
                </a>
                <a href="{{ route('admin.avisos.index') }}" class="flex-1 bg-white/10 hover:bg-white/20 p-2 rounded-lg text-center transition">
                    <i class="fas fa-bullhorn block text-sm mb-1"></i>
                    <span class="text-xs font-bold">Aviso</span>
                </a>
            </div>
        </div>
    </div>

    {{-- 4. CONTEÚDO PRINCIPAL (Grid Assimétrico) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- COLUNA ESQUERDA (2/3): Tabela de Alunos Recentes --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800">Últimas Matrículas</h3>
                    <a href="{{ route('admin.alunos.index') }}" class="text-xs font-bold text-blue-600 hover:underline uppercase tracking-wide">Ver todos</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 text-xs font-bold text-slate-400 uppercase">
                            <tr>
                                <th class="px-6 py-3">Aluno</th>
                                <th class="px-6 py-3">Série</th>
                                <th class="px-6 py-3 text-right">Data</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($novosAlunos ?? [] as $aluno)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center text-xs font-bold">
                                            {{ substr($aluno->nome_completo, 0, 2) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-700 text-sm">{{ $aluno->nome_completo }}</p>
                                            <p class="text-xs text-slate-400">{{ $aluno->email_aluno ?? 'Sem email' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-bold px-2 py-1 rounded-full bg-blue-50 text-blue-700">
                                        {{ str_replace('_', ' ', strtoupper($aluno->serie)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-xs text-slate-400 font-medium">
                                        {{ $aluno->created_at->format('d/m') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-8 text-center text-slate-400">
                                    Nenhum aluno cadastrado recentemente.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- COLUNA DIREITA (1/3): Avisos e Ferramentas --}}
        <div class="space-y-6">

            {{-- Widget de Avisos --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800">Mural Recente</h3>
                    <a href="{{ route('admin.avisos.index') }}" class="text-xs font-bold text-blue-600 hover:underline uppercase tracking-wide">Gerenciar</a>
                </div>
                <div class="p-4 space-y-3">
                    @forelse($ultimosAvisos ?? [] as $aviso)
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 hover:border-blue-200 transition group">
                            <div class="flex justify-between items-start mb-1">
                                <span class="text-[10px] font-bold text-slate-400 uppercase">{{ $aviso->created_at->format('d M') }}</span>
                                @if($aviso->fixado) <i class="fas fa-thumbtack text-xs text-amber-400"></i> @endif
                            </div>
                            <h4 class="font-bold text-slate-700 text-sm group-hover:text-blue-600 transition">{{ $aviso->titulo }}</h4>
                            <p class="text-xs text-slate-500 line-clamp-2 mt-1">{{ $aviso->conteudo }}</p>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400">
                            <i class="far fa-bell-slash text-2xl mb-2 opacity-50"></i>
                            <p class="text-xs">Nenhum aviso publicado.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Widget de Ferramentas --}}
            <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6">
                <h3 class="font-bold text-slate-800 mb-4">Ferramentas</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.aulas.index') }}" class="flex items-center gap-3 p-3 bg-white rounded-xl border border-slate-100 hover:shadow-md hover:border-blue-100 transition group">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <span class="text-sm font-bold text-slate-700">Upload de Materiais</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.chamada.index') }}" class="flex items-center gap-3 p-3 bg-white rounded-xl border border-slate-100 hover:shadow-md hover:border-blue-100 transition group">
                            <div class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center group-hover:scale-110 transition">
                                <i class="fas fa-history"></i>
                            </div>
                            <span class="text-sm font-bold text-slate-700">Histórico de Aulas</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>
@endsection
