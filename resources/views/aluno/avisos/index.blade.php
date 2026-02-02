@extends('layouts.aluno')

@section('title', 'Mural de avisos')

@section('content')

{{-- Passa dados do PHP para o JS de forma segura --}}
<script>
    window.avisosData = @json($avisos);
</script>

<div class="max-w-6xl mx-auto py-4 md:py-8 px-2 md:px-4"
     x-data="{
        modalOpen: false,
        avisoAtual: {},

        abrirModal(id) {
            this.avisoAtual = window.avisosData.find(a => a.id === id);
            if(!this.avisoAtual.mentor) this.avisoAtual.mentor = { nome: 'Equipe' };
            this.modalOpen = true;
            document.body.style.overflow = 'hidden';
        },

        fecharModal() {
            this.modalOpen = false;
            document.body.style.overflow = 'auto';
        },

        formatarData(dataString) {
            if(!dataString) return '';
            const data = new Date(dataString);
            return data.toLocaleDateString('pt-BR', { day: '2-digit', month: 'short', year: 'numeric' });
        }
     }">

    {{-- Header da Página --}}
    <div class="mb-6 md:mb-8 text-center md:text-left">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Mural de avisos </h1>
        <p class="text-sm md:text-base text-slate-500 mt-1">Fique por dentro das novidades e comunicados.</p>
    </div>

    {{-- Grid de Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">

        @forelse($avisos as $aviso)
            @php
                $euCurti = $aviso->curtidas->contains('id', Auth::guard('aluno')->id());
                $textoLongo = Str::length($aviso->conteudo) > 150;
                $imagemUrl = $aviso->imagem ? asset('storage/' . $aviso->imagem) : '';
                $autorNome = $aviso->mentor->nome ?? 'Equipe';
            @endphp

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 flex flex-col h-full relative group hover:shadow-xl hover:-translate-y-1 transition duration-300 overflow-hidden cursor-pointer"
                 @click="abrirModal({{ $aviso->id }})">

                {{-- Fixado --}}
                @if($aviso->fixado)
                    <div class="absolute top-3 right-3 bg-blue-600 text-white text-[10px] font-black px-3 py-1 rounded-full shadow-lg z-10 flex items-center gap-1 uppercase tracking-wider pointer-events-none">
                        <i class="fas fa-thumbtack transform rotate-45"></i> Fixado
                    </div>
                @endif

                {{-- Imagem --}}
                @if($aviso->imagem)
                    <div class="h-48 w-full bg-slate-100 overflow-hidden relative">
                        <img src="{{ $imagemUrl }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-60"></div>
                    </div>
                @endif

                <div class="p-5 md:p-6 flex-1 flex flex-col">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-[10px] font-bold bg-slate-100 text-slate-500 px-2 py-1 rounded uppercase tracking-wide">
                            {{ $aviso->created_at->format('d M, Y') }}
                        </span>
                    </div>

                    <h3 class="font-bold text-lg text-slate-800 leading-tight mb-3 group-hover:text-blue-600 transition">
                        {{ $aviso->titulo }}
                    </h3>

                    <div class="flex-1">
                        <p class="text-slate-500 text-sm leading-relaxed line-clamp-4">
                            {{ $aviso->conteudo }}
                        </p>

                        @if($textoLongo)
                            <button type="button" class="mt-2 text-xs font-bold text-blue-600 hover:text-blue-800 hover:underline transition bg-transparent border-none p-0 cursor-pointer">
                                Ler mais...
                            </button>
                        @endif
                    </div>

                    {{-- Footer do Card --}}
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100 mt-4" @click.stop>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold border border-indigo-100">
                                {{ substr($autorNome, 0, 2) }}
                            </div>
                            <div class="text-xs">
                                <p class="text-slate-700 font-bold">{{ $autorNome }}</p>
                                <p class="text-slate-400">Mentor</p>
                            </div>
                        </div>

                        <form action="{{ route('aluno.avisos.like', $aviso->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full transition text-xs font-bold {{ $euCurti ? 'bg-red-50 text-red-500 hover:bg-red-100' : 'bg-slate-50 text-slate-400 hover:text-red-400 hover:bg-red-50' }}">
                                <i class="{{ $euCurti ? 'fas' : 'far' }} fa-heart text-sm {{ $euCurti ? 'animate-pulse' : '' }}"></i>
                                <span>{{ $aviso->curtidas->count() }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="far fa-newspaper text-3xl text-slate-300"></i>
                </div>
                <p class="text-slate-400 text-sm">Nenhum aviso foi publicado.</p>
            </div>
        @endforelse

    </div>

    {{-- MODAL RESPONSIVO --}}
    <div x-show="modalOpen" style="display: none;"
         class="fixed inset-0 z-50 flex items-center justify-center p-0 md:p-4">

        {{-- Backdrop com Blur --}}
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
             @click="fecharModal()"></div>

        {{-- Container do Modal (Responsivo: mx-4 no mobile, w-full no desktop) --}}
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[85vh] md:max-h-[90vh] mx-4 md:mx-auto overflow-y-auto relative z-10 flex flex-col scrollbar-hide"
             x-show="modalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-10 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-10 scale-95">

            {{-- Botão Fechar (Fixo no topo direito) --}}
            <button @click="fecharModal()" class="absolute top-4 right-4 z-20 bg-white/90 hover:bg-white text-slate-500 hover:text-red-500 rounded-full p-2 shadow-md cursor-pointer transition">
                <i class="fas fa-times text-xl"></i>
            </button>

            {{-- Imagem do Modal --}}
            <template x-if="avisoAtual.imagem">
                <div class="w-full h-48 md:h-64 bg-slate-100 shrink-0">
                    <img :src="'/storage/' + avisoAtual.imagem" class="w-full h-full object-cover">
                </div>
            </template>

            {{-- Conteúdo do Modal --}}
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-xs font-bold bg-blue-50 text-blue-600 px-3 py-1 rounded-full uppercase tracking-wide"
                          x-text="formatarData(avisoAtual.created_at)"></span>
                    <span class="text-xs text-slate-400 font-medium flex items-center gap-1">
                        <i class="fas fa-user-edit"></i> <span x-text="avisoAtual.mentor ? avisoAtual.mentor.nome : 'Equipe'"></span>
                    </span>
                </div>

                <h2 class="text-xl md:text-3xl font-bold text-slate-800 mb-6 leading-tight" x-text="avisoAtual.titulo"></h2>

                <div class="prose prose-slate prose-sm md:prose-base max-w-none text-slate-600 leading-relaxed whitespace-pre-line text-justify"
                     x-text="avisoAtual.conteudo"></div>
            </div>

            {{-- Footer do Modal --}}
            <div class="p-4 md:p-6 border-t border-slate-50 bg-slate-50 flex justify-end rounded-b-2xl mt-auto">
                <button @click="fecharModal()" class="w-full md:w-auto px-6 py-3 bg-slate-800 text-white rounded-xl font-bold text-sm hover:bg-slate-900 transition shadow-lg">
                    Fechar
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
