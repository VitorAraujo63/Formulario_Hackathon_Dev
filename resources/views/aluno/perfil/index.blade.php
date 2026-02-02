@extends('layouts.aluno')

@section('title', 'Meu Perfil')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">

    @if(session('sucesso'))
        <div class="mb-6 bg-green-50 text-green-700 p-4 rounded-xl border border-green-100 flex items-center gap-3 animate-pulse">
            <i class="fas fa-check-circle text-xl"></i>
            <span class="font-bold">{{ session('sucesso') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-50 text-red-700 p-4 rounded-xl border border-red-100">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-8 text-center md:text-left">
        <h1 class="text-3xl font-bold text-slate-800">Meu Perfil</h1>
        <p class="text-slate-500 mt-1">Gerencie suas informações de acesso.</p>
    </div>

    <form action="{{ route('aluno.perfil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- COLUNA FOTO --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 text-center relative overflow-hidden group">
                    <div class="absolute inset-x-0 top-0 h-24 bg-gradient-to-b from-green-50 to-white"></div>

                    <div class="relative z-10">
                        <div class="w-32 h-32 mx-auto rounded-full p-1 bg-white border-4 border-green-100 shadow-sm relative mb-4">

                            {{-- LÓGICA DA IMAGEM ATUALIZADA (Via Proxy Laravel) --}}
                            @if($aluno->foto)
                                {{-- basename pega 'abc.webp' de 'fotos_alunos/abc.webp' --}}
                                <img id="preview-foto" src="{{ route('aluno.foto.proxy', basename($aluno->foto)) }}" class="w-full h-full rounded-full object-cover">
                            @else
                                <div id="preview-default" class="w-full h-full rounded-full bg-green-50 flex items-center justify-center text-green-600 text-3xl font-bold">
                                    {{ substr($aluno->nome_completo, 0, 2) }}
                                </div>
                                <img id="preview-foto" class="hidden w-full h-full rounded-full object-cover">
                            @endif

                            <label for="input-foto" class="absolute bottom-0 right-0 bg-slate-800 text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer hover:bg-slate-900 transition shadow-lg" title="Alterar foto">
                                <i class="fas fa-camera text-xs"></i>
                            </label>
                            <input type="file" name="foto" id="input-foto" class="hidden" accept="image/*" onchange="previewImage(event)">
                        </div>

                        <h3 class="font-bold text-slate-800 text-lg">{{ explode(' ', $aluno->nome_completo)[0] }}</h3>
                        <p class="text-xs text-slate-400 font-medium bg-slate-100 py-1 px-3 rounded-full inline-block mt-2">Aluno</p>
                    </div>
                </div>

                <button type="submit" class="w-full bg-green-600 text-white font-bold py-3.5 rounded-xl hover:bg-green-700 transition shadow-lg shadow-green-200 flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> Salvar Alterações
                </button>
            </div>

            {{-- COLUNA DADOS --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- (O restante do formulário permanece igual ao anterior) --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
                    <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <i class="fas fa-user-edit text-green-600"></i> Informações Editáveis
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nome Completo / Social</label>
                            <input type="text" name="nome_completo" value="{{ old('nome_completo', $aluno->nome_completo) }}" class="w-full border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-green-100 focus:border-green-500 border outline-none transition bg-white text-slate-700 font-medium">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Meu Telefone / WhatsApp</label>
                            <input type="text" name="telefone_aluno" value="{{ old('telefone_aluno', $aluno->telefone_aluno) }}" placeholder="(00) 00000-0000" class="w-full border-slate-200 rounded-xl p-3 focus:ring-2 focus:ring-green-100 focus:border-green-500 border outline-none transition bg-white text-slate-700 font-medium">
                        </div>
                    </div>
                </div>

                {{-- Seção: Dados Escolares (Bloqueado) --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 opacity-90">
                    <h2 class="text-lg font-bold text-slate-600 mb-6 flex items-center gap-2">
                        <i class="fas fa-school text-slate-400"></i> Dados Escolares <span class="text-[10px] bg-slate-100 px-2 py-0.5 rounded text-slate-400 ml-auto">Fixo</span>
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Escola</label>
                            <input type="text" value="{{ $aluno->escola }}" disabled class="w-full border-slate-100 bg-slate-50 rounded-xl p-3 text-slate-500 cursor-not-allowed font-medium select-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Série / Ano</label>
                            <input type="text" value="{{ str_replace('_', ' ', strtoupper($aluno->serie)) }}" disabled class="w-full border-slate-100 bg-slate-50 rounded-xl p-3 text-slate-500 cursor-not-allowed font-medium select-none">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">E-mail de Acesso</label>
                            <input type="text" value="{{ $aluno->email_aluno }}" disabled class="w-full border-slate-100 bg-slate-50 rounded-xl p-3 text-slate-500 cursor-not-allowed font-medium select-none">
                        </div>
                    </div>
                </div>

                {{-- Seção: Responsável (Bloqueado) --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 opacity-90">
                    <h2 class="text-lg font-bold text-slate-600 mb-6 flex items-center gap-2">
                        <i class="fas fa-user-shield text-slate-400"></i> Dados do Responsável <span class="text-[10px] bg-slate-100 px-2 py-0.5 rounded text-slate-400 ml-auto">Fixo</span>
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Nome do Responsável</label>
                            <input type="text" value="{{ $aluno->nome_responsavel }}" disabled class="w-full border-slate-100 bg-slate-50 rounded-xl p-3 text-slate-500 cursor-not-allowed font-medium select-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Telefone Responsável</label>
                            <input type="text" value="{{ $aluno->telefone_responsavel }}" disabled class="w-full border-slate-100 bg-slate-50 rounded-xl p-3 text-slate-500 cursor-not-allowed font-medium select-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">E-mail Responsável</label>
                            <input type="text" value="{{ $aluno->email_responsavel }}" disabled class="w-full border-slate-100 bg-slate-50 rounded-xl p-3 text-slate-500 cursor-not-allowed font-medium select-none">
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-slate-50 border border-slate-100 rounded-lg flex gap-3 items-start">
                        <i class="fas fa-info-circle text-slate-400 mt-0.5"></i>
                        <p class="text-xs text-slate-500 leading-tight">
                            Para alterar os dados fixos ou do responsável, entre em contato com algum dos mentores.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('preview-foto');
            const defaultDiv = document.getElementById('preview-default');
            output.src = reader.result;
            output.classList.remove('hidden');
            if(defaultDiv) defaultDiv.classList.add('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
