@extends('layouts.mentor')

@section('title', 'Logs de Auditoria')

@section('content')
<div class="max-w-7xl mx-auto">
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Logs de Auditoria</h1>
        <p class="text-slate-500 mt-1">Histórico completo de ações realizadas no sistema.</p>
    </header>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-sm border border-slate-100 p-4 mb-6">
        <form method="GET" action="{{ route('admin.logs.index') }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Tipo de Ação</label>
                <select name="acao" class="w-full border-slate-200 rounded-lg p-2.5 border outline-none bg-white">
                    <option value="">Todas as ações</option>
                    @foreach($tiposAcao as $tipo)
                        <option value="{{ $tipo }}" {{ $filtroAcao == $tipo ? 'selected' : '' }}>
                            {{ $tipo }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="bg-slate-800 text-white px-6 py-2.5 rounded-lg hover:bg-slate-900 font-semibold transition">
                    <i class="fas fa-filter mr-2"></i> Filtrar
                </button>
                @if($filtroAcao)
                    <a href="{{ route('admin.logs.index') }}" class="ml-2 text-slate-500 hover:text-slate-700 px-4 py-2.5 font-semibold">
                        Limpar
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Tabela de Logs --}}
    <div class="bg-white rounded-lg shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Usuário</th>
                        <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Ação</th>
                        <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Descrição</th>
                        <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">IP</th>
                        <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Data/Hora</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                @if($log->mentor)
                                    {{-- Foto do mentor via proxy --}}
                                    @if($log->mentor->foto)
                                        <img src="{{ route('mentor.foto.proxy', basename($log->mentor->foto)) }}"
                                             class="w-8 h-8 rounded-full object-cover border border-slate-200"
                                             onerror="this.src='http://ui-avatars.com/api/?name={{ urlencode($log->mentor->nome) }}&background=random'"
                                             alt="{{ $log->mentor->nome }}">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs border border-blue-200">
                                            {{ substr($log->mentor->nome, 0, 2) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-semibold text-slate-800">{{ $log->mentor->nome }}</div>
                                        <div class="text-xs text-slate-400">{{ $log->mentor->email }}</div>
                                    </div>
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-robot text-xs text-gray-400"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-800">Sistema</div>
                                        <div class="text-xs text-slate-400">Automático</div>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded-full text-xs font-bold
                                {{ $log->acao == 'Criação' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $log->acao == 'Edição' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $log->acao == 'Exclusão' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $log->acao == 'Permissões' ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ !in_array($log->acao, ['Criação', 'Edição', 'Exclusão', 'Permissões']) ? 'bg-slate-100 text-slate-700' : '' }}
                            ">
                                {{ $log->acao }}
                            </span>
                        </td>
                        <td class="p-4 text-sm text-slate-600">{{ $log->descricao }}</td>
                        <td class="p-4 text-xs text-slate-400 font-mono">{{ $log->ip_address }}</td>
                        <td class="p-4 text-sm text-slate-500 whitespace-nowrap">
                            {{ $log->created_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-slate-400">
                            <i class="far fa-folder-open text-4xl mb-3 block opacity-50"></i>
                            Nenhum log encontrado.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginação --}}
        @if($logs->hasPages())
        <div class="border-t border-slate-100 p-4">
            {{ $logs->links() }}
        </div>
        @endif
    </div>

    {{-- Estatísticas --}}
    <div class="mt-6 text-sm text-slate-500 text-center">
        Exibindo {{ $logs->count() }} de {{ $logs->total() }} registros
    </div>
</div>
@endsection
