@extends('layouts.mentor')

@section('title', 'Controle de Presença')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Salas de Aula</h1>
            <p class="text-slate-500 mt-1">Gerencie as chamadas e acompanhe a frequência.</p>
        </div>

        <button onclick="openModal('modal-nova-chamada')"
                class="w-full md:w-auto bg-blue-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 transition flex items-center justify-center gap-2">
            <i class="fas fa-plus-circle"></i> Iniciar Nova Chamada
        </button>
    </div>

    {{-- Grid de Chamadas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($chamadas as $chamada)
            <div class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:border-blue-100 transition-all duration-300 flex flex-col overflow-hidden relative">

                {{-- Status Badge --}}
                <div class="absolute top-4 right-4 z-10">
                    @if($chamada->ativa)
                        <span class="flex items-center gap-1 bg-green-100 text-green-700 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider animate-pulse">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span> Ao Vivo
                        </span>
                    @else
                        <span class="bg-slate-100 text-slate-500 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">
                            Finalizada
                        </span>
                    @endif
                </div>

                {{-- Corpo do Card --}}
                <div class="p-6 flex-1">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition">
                        <i class="fas fa-qrcode"></i>
                    </div>

                    <h3 class="font-bold text-lg text-slate-800 mb-1">{{ $chamada->titulo }}</h3>

                    <div class="flex flex-col gap-1 mb-4">
                        <p class="text-xs text-slate-400 font-mono">Sala: {{ $chamada->codigo_acesso }}</p>
                        {{-- NOVO: Mostra o nome do mentor dono da chamada --}}
                        <p class="text-xs text-slate-500 font-medium flex items-center gap-1">
                            <i class="fas fa-user-tie text-slate-300"></i>
                            {{ $chamada->mentor->nome ?? 'Mentor' }}
                        </p>
                    </div>

                    <div class="flex items-center gap-4 text-sm text-slate-500 border-t border-slate-50 pt-4 mt-2">
                        <div class="flex items-center gap-1">
                            <i class="fas fa-users text-slate-300"></i>
                            <span class="font-bold text-slate-700">{{ $chamada->presencas_count }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <i class="far fa-calendar text-slate-300"></i>
                            <span>{{ $chamada->created_at->format('d/m H:i') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Footer com Ações --}}
                <div class="bg-slate-50 p-4 border-t border-slate-100 flex gap-2">
                    @if($chamada->ativa)
                        <a href="{{ route('admin.chamada.painel', $chamada->id) }}" class="flex-1 bg-blue-600 text-white text-center py-2 rounded-lg text-xs font-bold uppercase hover:bg-blue-700 transition">
                            Acessar Painel
                        </a>
                    @else
                        <a href="{{ route('admin.chamada.export', $chamada->id) }}" class="flex-1 bg-white border border-slate-200 text-slate-600 text-center py-2 rounded-lg text-xs font-bold uppercase hover:bg-slate-50 transition flex items-center justify-center gap-2">
                            <i class="fas fa-download"></i> Baixar Lista
                        </a>
                        <a href="{{ route('admin.chamada.painel', $chamada->id) }}" class="px-3 py-2 text-slate-400 hover:text-blue-600 transition" title="Visualizar">
                            <i class="fas fa-eye"></i>
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                    <i class="fas fa-clipboard-list text-3xl text-slate-300"></i>
                </div>
                <h3 class="text-slate-800 font-bold text-lg">Nenhuma chamada encontrada</h3>
                <p class="text-slate-400 text-sm mt-1 max-w-sm mx-auto">Clique no botão "Iniciar Nova Chamada" para gerar um QR Code.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- MODAL NOVA CHAMADA --}}
<div id="modal-nova-chamada" class="fixed inset-0 bg-slate-900/60 hidden z-50 flex items-center justify-center backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden transform transition-all scale-100">
        <div class="bg-slate-800 text-white px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-bold">Nova Chamada</h3>
            <button onclick="closeModal('modal-nova-chamada')" class="text-slate-400 hover:text-white text-2xl">&times;</button>
        </div>

        <form action="{{ route('admin.chamada.store') }}" method="POST" class="p-6">
            @csrf

            <div class="mb-4">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Sala de Aula</label>
                <input type="text" name="sala" required
                       class="w-full border-slate-200 rounded-lg p-3 outline-none focus:ring-2 focus:ring-blue-100 border text-slate-800 font-bold text-lg"
                       placeholder="Ex: 429">
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Título (Opcional)</label>
                <input type="text" name="titulo"
                       value="Aula do dia {{ date('d/m') }}"
                       class="w-full border-slate-200 rounded-lg p-3 outline-none focus:ring-2 focus:ring-blue-100 border text-slate-800"
                       placeholder="Ex: Introdução ao PHP">
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('modal-nova-chamada')" class="px-4 py-2 text-slate-500 font-bold text-sm hover:text-slate-700">Cancelar</button>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold text-sm shadow-lg shadow-blue-200">
                    Abrir Chamada
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); document.body.classList.add('overflow-hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); document.body.classList.remove('overflow-hidden'); }
</script>
@endsection
