@extends('layouts.mentor')

@section('title', 'Meu Perfil')

@section('content')
<div class="max-w-4xl mx-auto py-6 md:py-10 px-4">

    <div class="mb-8 text-center md:text-left">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Meu Perfil</h1>
        <p class="text-sm md:text-base text-slate-500">Gerencie suas informações pessoais e credenciais.</p>
    </div>

    <form action="{{ route('mentor.perfil.update') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-sm border border-slate-100 rounded-2xl overflow-hidden">
        @csrf

        {{-- Capa --}}
        <div class="h-24 md:h-32 bg-gradient-to-r from-slate-800 to-slate-900 relative">
            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
        </div>

        <div class="px-4 md:px-8 pb-8 -mt-12 md:-mt-16">
            <div class="flex flex-col items-center mb-8 md:mb-10">
                <div class="relative group">
                    @php
                        $user = Auth::guard('mentor')->user();
                    @endphp

                    {{-- Foto --}}
                    <img id="preview" src="{{ $user->foto_url }}"
                        class="w-24 h-24 md:w-32 md:h-32 rounded-full object-cover border-[6px] border-white shadow-xl bg-white relative z-10">

                    <label class="absolute inset-0 z-20 flex items-center justify-center bg-black/50 rounded-full opacity-0 group-hover:opacity-100 cursor-pointer transition-all duration-300 backdrop-blur-sm border-[6px] border-transparent">
                        <i class="fas fa-camera text-white text-xl md:text-2xl drop-shadow-md"></i>
                        <input type="file" name="foto" class="hidden" onchange="previewImage(event)">
                    </label>

                    <div class="absolute bottom-1 right-1 md:bottom-2 md:right-2 z-30 bg-blue-600 text-white w-7 h-7 md:w-8 md:h-8 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                        <i class="fas fa-pen text-[10px] md:text-xs"></i>
                    </div>
                </div>

                <h2 class="mt-3 md:mt-4 text-xl md:text-2xl font-bold text-slate-800 text-center">{{ $user->nome }}</h2>
                <p class="text-slate-400 text-xs md:text-sm font-medium bg-slate-50 px-3 py-1 rounded-full mt-1 border border-slate-100">
                    {{ $user->funcao ?? 'Mentor' }}
                </p>
            </div>

            {{-- Grid do Formulário --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 max-w-2xl mx-auto">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nome Completo</label>
                    <input type="text" name="nome" value="{{ $user->nome }}" class="w-full border-slate-200 rounded-lg p-3 outline-none focus:ring-2 focus:ring-blue-100 border transition">
                </div>

                <div class="col-span-1 md:col-span-2 border-t border-slate-50 my-1 md:my-2"></div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nova Senha</label>
                    <input type="password" name="password" placeholder="••••••••" class="w-full border-slate-200 rounded-lg p-3 outline-none focus:ring-2 focus:ring-blue-100 border transition">
                    <p class="text-[10px] text-slate-400 mt-1">Deixe em branco para manter a atual.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Confirmar Senha</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full border-slate-200 rounded-lg p-3 outline-none focus:ring-2 focus:ring-blue-100 border transition">
                </div>
            </div>

            <div class="mt-8 md:mt-10 pt-6 border-t border-slate-50 flex justify-end">
                <button type="submit" class="w-full md:w-auto bg-slate-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-black transition shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm uppercase tracking-wider">
                    Salvar Alterações
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = () => document.getElementById('preview').src = reader.result;
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
