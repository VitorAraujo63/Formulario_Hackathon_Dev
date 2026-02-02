@extends('layouts.aluno')

@section('title', 'Minha Frequência')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">

    <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="text-center md:text-left">
            <h1 class="text-3xl font-bold text-slate-800">Minha Frequência</h1>
            <p class="text-slate-500 mt-1">Histórico completo de presenças registradas.</p>
        </div>

        <div class="bg-indigo-50 text-indigo-700 px-5 py-2 rounded-xl text-center border border-indigo-100 shadow-sm">
            <span class="block text-3xl font-black">{{ $presencas->count() }}</span>
            <span class="text-xs uppercase font-bold tracking-wide opacity-80">Aulas Presente</span>
        </div>
    </div>

    @if($presencas->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="far fa-calendar-times text-3xl text-slate-300"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-700">Nenhum registro encontrado</h3>
            <p class="text-slate-400 text-sm mt-1">Você ainda não registrou presença em nenhuma aula.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($presencas as $chamada)
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex flex-col md:flex-row md:items-center gap-4 hover:border-blue-200 transition group">

                    {{-- Data (Esquerda) --}}
                    <div class="flex md:flex-col items-center gap-2 md:gap-0 md:w-24 md:text-center shrink-0 border-b md:border-b-0 md:border-r border-slate-50 pb-2 md:pb-0 md:pr-4">
                        {{-- Usa pivot->registrado_em se existir, senão usa created_at --}}
                        @php $data = $chamada->pivot->registrado_em ?? $chamada->created_at; @endphp
                        <span class="text-2xl font-bold text-slate-700">{{ \Carbon\Carbon::parse($data)->format('d') }}</span>
                        <span class="text-xs font-bold text-slate-400 uppercase">{{ \Carbon\Carbon::parse($data)->translatedFormat('M Y') }}</span>
                    </div>

                    {{-- Detalhes --}}
                    <div class="flex-1">
                        <div class="flex flex-col md:flex-row justify-between md:items-center gap-2">
                            <div>
                                <h3 class="font-bold text-slate-800 text-lg group-hover:text-blue-600 transition">{{ $chamada->titulo }}</h3>
                                <div class="flex flex-wrap gap-2 text-xs mt-1">
                                    <span class="bg-slate-100 text-slate-500 px-2 py-0.5 rounded font-mono">
                                        Sala: {{ $chamada->codigo_acesso }}
                                    </span>
                                    <span class="text-slate-400 flex items-center gap-1">
                                        <i class="fas fa-user-tie"></i> {{ $chamada->mentor->nome ?? 'Mentor' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Badge de Status --}}
                            <div class="flex items-center justify-between md:flex-col md:items-end gap-2">
                                @if($chamada->pivot->manual)
                                    <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 text-[10px] font-bold px-3 py-1 rounded-full uppercase border border-amber-100">
                                        <i class="fas fa-user-edit"></i> Manual
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 text-[10px] font-bold px-3 py-1 rounded-full uppercase border border-green-100">
                                        <i class="fas fa-qrcode"></i> QR Code
                                    </span>
                                @endif
                                <span class="text-[10px] text-slate-400 font-mono">
                                    {{ \Carbon\Carbon::parse($data)->format('H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
