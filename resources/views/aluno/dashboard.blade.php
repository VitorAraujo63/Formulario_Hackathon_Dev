@extends('layouts.aluno')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">

    {{-- 1. HEADER COM DATA E SAUDAÇÃO --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div class="flex items-center gap-4">
            {{-- Foto do Perfil (Com Proxy) --}}
            <div class="hidden md:block w-16 h-16 rounded-2xl p-1 bg-white border border-slate-200 shadow-sm">
                @if($aluno->foto)
                    <img src="{{ route('aluno.foto.proxy', basename($aluno->foto)) }}" class="w-full h-full rounded-xl object-cover">
                @else
                    <div class="w-full h-full rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xl">
                        {{ substr($aluno->nome_completo, 0, 2) }}
                    </div>
                @endif
            </div>

            <div>
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">
                    Olá, {{ explode(' ', $aluno->nome_completo)[0] }}!
                </h1>
                <p class="text-slate-500 mt-1">
                    Resumo do seu aprendizado hoje, <span class="font-bold text-slate-700 capitalize">{{ now()->translatedFormat('l, d \d\e F') }}</span>.
                </p>
            </div>
        </div>

        {{-- Botão de Ação Rápida --}}
        <a href="{{ route('aluno.perfil') }}" class="bg-white border border-slate-200 text-slate-600 px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-50 hover:text-blue-600 transition shadow-sm flex items-center gap-2">
            <i class="fas fa-user-cog"></i> Configurar Perfil
        </a>
    </div>

    {{-- 2. HERO: CHAMADA ATIVA (Estilo Mentor, mas Verde/Esmeralda) --}}
    @if($chamadaAtiva)
    <div class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 shadow-xl shadow-emerald-200 text-white p-6 flex flex-col md:flex-row items-center justify-between gap-6 group">

        {{-- Decorativo --}}
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl group-hover:opacity-20 transition duration-1000"></div>

        <div class="flex items-center gap-4 z-10">
            <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm animate-pulse border border-white/30">
                <i class="fas fa-qrcode text-2xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg leading-tight flex items-center gap-2">
                    Chamada Aberta!
                    <span class="text-[10px] bg-white/20 px-2 py-0.5 rounded-full border border-white/20">Ao vivo</span>
                </h3>
                <p class="text-emerald-50 text-sm mt-1">
                    Sala: <span class="font-mono font-bold bg-black/10 px-2 py-0.5 rounded">{{ $chamadaAtiva->codigo_acesso }}</span> •
                    Mentor: <span class="font-bold">{{ $chamadaAtiva->mentor->nome ?? 'Mentor' }}</span>
                </p>
            </div>
        </div>

        <a href="{{ route('aluno.frequencia') }}" class="z-10 bg-white text-emerald-700 px-6 py-3 rounded-xl font-bold shadow-lg hover:bg-emerald-50 transition transform hover:scale-105 flex items-center gap-2">
            <i class="fas fa-camera"></i> Registrar Presença
        </a>
    </div>
    @endif

    {{-- 3. CARDS DE ESTATÍSTICAS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Card 1: Frequência --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition group">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl group-hover:scale-110 transition">
                <i class="fas fa-chart-pie"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Minha Frequência</p>
                <div class="flex items-baseline gap-1">
                    <h4 class="text-2xl font-black text-slate-800">{{ $frequenciaPercent }}%</h4>
                    @if($frequenciaPercent >= 75)
                        <span class="text-[10px] text-green-500 font-bold"><i class="fas fa-arrow-up"></i> Ótimo</span>
                    @else
                        <span class="text-[10px] text-amber-500 font-bold"><i class="fas fa-exclamation"></i> Atenção</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Card 2: Presenças Totais --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition group">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl group-hover:scale-110 transition">
                <i class="fas fa-check-double"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Aulas Assistidas</p>
                <h4 class="text-2xl font-black text-slate-800">{{ $minhasPresencas }}</h4>
            </div>
        </div>

        {{-- Card 3: Materiais Disponíveis (Calculado na View ou Controller) --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition group">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl group-hover:scale-110 transition">
                <i class="fas fa-folder-open"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Materiais</p>
                <h4 class="text-2xl font-black text-slate-800">{{ $materiais->count() }}</h4>
            </div>
        </div>
    </div>

    {{-- 4. CONTEÚDO PRINCIPAL (Grid Assimétrico) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- COLUNA ESQUERDA (2/3): Materiais Recentes (Estilo Tabela) --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-book text-blue-500"></i> Materiais Recentes
                    </h3>
                    <a href="{{ route('aluno.materiais') }}" class="text-xs font-bold text-blue-600 hover:underline uppercase tracking-wide">Ver Biblioteca</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 text-xs font-bold text-slate-400 uppercase">
                            <tr>
                                <th class="px-6 py-3">Conteúdo</th>
                                <th class="px-6 py-3">Categoria</th>
                                <th class="px-6 py-3 text-right">Ação</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($materiais->take(5) as $aula)
                            <tr class="hover:bg-slate-50/50 transition group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg shrink-0 border border-indigo-100">
                                            {{ substr($aula->titulo, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-700 text-sm group-hover:text-blue-600 transition">{{ $aula->titulo }}</p>
                                            <p class="text-xs text-slate-400">
                                                {{ $aula->recursos->count() }} arquivo(s) • {{ $aula->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-bold px-2 py-1 rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                        {{ $aula->categoria->nome ?? 'Geral' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('aluno.materiais') }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-50 text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition">
                                        <i class="fas fa-download text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-8 text-center text-slate-400">
                                    <div class="flex flex-col items-center">
                                        <i class="far fa-folder-open text-3xl mb-2 opacity-50"></i>
                                        <p>Nenhum material postado recentemente.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- COLUNA DIREITA (1/3): Avisos e Atalhos --}}
        <div class="space-y-6">

            {{-- Widget de Avisos --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-bullhorn text-amber-500"></i> Mural
                    </h3>
                    <a href="{{ route('aluno.avisos.index') }}" class="text-xs font-bold text-blue-600 hover:underline uppercase tracking-wide">Ver Todos</a>
                </div>
                <div class="p-4 space-y-3">
                    @forelse($avisos->take(3) as $aviso)
                        <a href="{{ route('aluno.avisos.index') }}" class="block p-4 bg-slate-50 rounded-xl border border-slate-100 hover:border-blue-200 hover:shadow-sm transition group">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-bold bg-white text-slate-400 px-2 py-0.5 rounded border border-slate-100">{{ $aviso->created_at->format('d M') }}</span>
                                @if($aviso->fixado) <i class="fas fa-thumbtack text-xs text-amber-400 transform rotate-45"></i> @endif
                            </div>
                            <h4 class="font-bold text-slate-700 text-sm group-hover:text-blue-600 transition leading-tight">{{ $aviso->titulo }}</h4>
                            <p class="text-xs text-slate-500 line-clamp-2 mt-1">{{ $aviso->conteudo }}</p>
                        </a>
                    @empty
                        <div class="text-center py-8 text-slate-400">
                            <p class="text-xs">Nenhum aviso no momento.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Widget de Ferramentas / Atalhos --}}
            <div class="bg-slate-50 rounded-2xl border border-slate-200 p-6">
                <h3 class="font-bold text-slate-800 mb-4">Acesso Rápido</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('aluno.frequencia') }}" class="flex items-center gap-3 p-3 bg-white rounded-xl border border-slate-100 hover:shadow-md hover:border-blue-100 transition group">
                            <div class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center group-hover:scale-110 transition">
                                <i class="fas fa-history"></i>
                            </div>
                            <span class="text-sm font-bold text-slate-700">Histórico de Frequência</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('aluno.perfil') }}" class="flex items-center gap-3 p-3 bg-white rounded-xl border border-slate-100 hover:shadow-md hover:border-blue-100 transition group">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center group-hover:scale-110 transition">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <span class="text-sm font-bold text-slate-700">Meu Cartão/Perfil</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>
@endsection
