@extends('layouts.aluno')

@section('title', 'Materiais de Aula')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">

    <div class="mb-8 text-center md:text-left">
        <h1 class="text-3xl font-bold text-slate-800">Materiais de Aula</h1>
        <p class="text-slate-500 mt-1">Acesse todo o conteúdo compartilhado pelos mentores.</p>
    </div>

    {{-- LISTA DE AULAS --}}
    <div class="space-y-6">
        @forelse($aulas as $aula)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition duration-300">

                {{-- Cabeçalho da Aula --}}
                <div class="p-6 border-b border-slate-50 bg-gradient-to-r from-slate-50 to-white">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2">
                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full w-fit uppercase tracking-wide">
                            {{ $aula->categoria->nome ?? 'Conteúdo' }}
                        </span>
                        <span class="text-xs font-medium text-slate-400 flex items-center gap-1">
                            <i class="far fa-calendar-alt"></i> {{ $aula->created_at->format('d/m/Y') }}
                        </span>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">{{ $aula->titulo }}</h2>

                    @if($aula->descricao)
                        <p class="text-slate-500 text-sm mt-2 leading-relaxed">{{ $aula->descricao }}</p>
                    @endif
                </div>

                {{-- Lista de Recursos (SIMPLIFICADA) --}}
                <div class="p-4 bg-white">
                    @if($aula->recursos_view->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($aula->recursos_view as $recurso)
                                <a href="{{ $recurso->url }}" target="_blank" class="group flex items-center p-3 rounded-xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50 transition">

                                    {{-- Ícone --}}
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-white border border-slate-100 shadow-sm mr-3 group-hover:scale-110 transition shrink-0">
                                        <i class="{{ $recurso->icon }} {{ $recurso->color }} text-lg"></i>
                                    </div>

                                    {{-- Texto --}}
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-slate-700 truncate group-hover:text-blue-700 transition">
                                            {{ $recurso->titulo }}
                                        </p>
                                        <p class="text-[10px] text-slate-400 truncate flex items-center gap-1">
                                            @if($recurso->is_safe)
                                                <i class="fas fa-lock text-[9px] text-green-500"></i>
                                            @endif
                                            {{ $recurso->action_text }}
                                        </p>
                                    </div>

                                    <i class="fas fa-external-link-alt text-slate-300 text-xs group-hover:text-blue-400"></i>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-slate-400 text-sm italic">
                            Nenhum arquivo anexado a esta aula.
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-20">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-book-reader text-3xl text-slate-300"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-700">Tudo limpo por aqui!</h3>
                <p class="text-slate-400 text-sm">Nenhum material foi publicado ainda.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
