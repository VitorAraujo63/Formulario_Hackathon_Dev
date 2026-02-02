@extends('layouts.mentor')

@section('title', 'Mural de Avisos')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Comunicados</h1>
            <p class="text-slate-500 mt-1">Mural oficial para alunos e mentores.</p>
        </div>

        <button onclick="openModal('modal-novo-aviso')"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 shadow-lg shadow-blue-200 flex items-center gap-2 transition font-semibold">
            <i class="fas fa-plus"></i> Novo Aviso
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($avisos as $aviso)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col h-full relative group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

            @if($aviso->fixado)
                <div class="absolute top-3 right-3 bg-amber-400 text-amber-900 text-[10px] font-black px-3 py-1 rounded-full shadow-md z-10 uppercase tracking-wide flex items-center gap-1">
                    <i class="fas fa-thumbtack"></i> Destaque
                </div>
            @endif

            @if($aviso->imagem)
                <div class="h-48 w-full bg-slate-100 overflow-hidden relative">
                    <img src="{{ asset('storage/' . $aviso->imagem) }}" alt="Imagem do aviso" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                </div>
            @else
                <div class="h-24 bg-gradient-to-r from-slate-100 to-slate-200 relative overflow-hidden">
                    <i class="fas fa-bullhorn absolute -bottom-4 -right-4 text-8xl text-slate-300 opacity-20 transform -rotate-12"></i>
                </div>
            @endif

            <div class="p-6 flex-1 flex flex-col">
                <h3 class="font-bold text-xl text-slate-800 leading-tight mb-3">{{ $aviso->titulo }}</h3>
                <p class="text-slate-600 text-sm mb-6 line-clamp-3 leading-relaxed">{{ $aviso->conteudo }}</p>

                <div class="mt-auto pt-4 border-t border-slate-50 flex justify-between items-center">
                    <span class="text-xs text-slate-400 font-medium">
                        {{ $aviso->created_at->format('d/m/Y') }}
                    </span>

                    @if($aviso->curtidas->count() > 0)
                        <button onclick="openLikesModal('likes-modal-{{ $aviso->id }}')" class="flex items-center gap-1 text-xs font-bold text-red-500 hover:text-red-600 bg-red-50 px-2 py-1 rounded-full transition">
                            <i class="fas fa-heart"></i> {{ $aviso->curtidas->count() }}
                        </button>
                    @endif
                </div>
            </div>

            <div class="bg-slate-50 px-6 py-3 border-t border-slate-100 flex justify-end gap-3 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                <button onclick="openEditModal({{ $aviso->id }}, '{{ $aviso->titulo }}', '{{ e($aviso->conteudo) }}', {{ $aviso->fixado }})"
                        class="w-8 h-8 rounded-full bg-white text-blue-500 shadow-sm border border-slate-200 hover:bg-blue-600 hover:text-white flex items-center justify-center transition">
                    <i class="fas fa-pencil-alt text-xs"></i>
                </button>

                <form action="{{ route('admin.avisos.destroy', $aviso->id) }}" method="POST" onsubmit="return confirm('Excluir este aviso?')">
                    @csrf @method('DELETE')
                    <button class="w-8 h-8 rounded-full bg-white text-red-400 shadow-sm border border-slate-200 hover:bg-red-500 hover:text-white flex items-center justify-center transition">
                        <i class="fas fa-trash-alt text-xs"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- Modal de Likes Específico --}}
        <div id="likes-modal-{{ $aviso->id }}" class="fixed inset-0 bg-slate-900/60 hidden z-[60] flex items-center justify-center backdrop-blur-sm" onclick="if(event.target === this) closeModal('likes-modal-{{ $aviso->id }}')">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-4 overflow-hidden">
                <div class="bg-red-500 text-white px-5 py-3 flex justify-between items-center">
                    <h3 class="font-bold text-sm uppercase tracking-wide">Curtidas</h3>
                    <button onclick="closeModal('likes-modal-{{ $aviso->id }}')" class="hover:text-red-200 text-xl">&times;</button>
                </div>
                <div class="p-4 max-h-64 overflow-y-auto">
                    <ul class="space-y-3">
                        @foreach($aviso->curtidas as $aluno)
                            <li class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center text-slate-500 text-xs font-bold border border-slate-200">
                                    {{ substr($aluno->nome_completo, 0, 2) }}
                                </div>
                                <span class="text-sm font-medium text-slate-700">{{ $aluno->nome_completo }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-bullhorn text-3xl text-slate-300"></i>
            </div>
            <h3 class="text-slate-800 font-bold">Mural Vazio</h3>
            <p class="text-slate-400 text-sm mt-1">Nenhum comunicado publicado ainda.</p>
        </div>
        @endforelse
    </div>
</div>

{{-- MODAL NOVO AVISO --}}
<div id="modal-novo-aviso" class="fixed inset-0 bg-slate-900/60 hidden z-50 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden">
        <div class="bg-slate-800 text-white px-6 py-4 flex justify-between items-center">
            <h3 class="font-bold">Nova Publicação</h3>
            <button onclick="closeModal('modal-novo-aviso')" class="text-slate-400 hover:text-white text-2xl">&times;</button>
        </div>
        <form action="{{ route('admin.avisos.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Título</label>
                    <input type="text" name="titulo" required class="w-full border-slate-200 rounded-lg p-3 outline-none focus:ring-2 focus:ring-blue-100 border">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Mensagem</label>
                    <textarea name="conteudo" rows="4" required class="w-full border-slate-200 rounded-lg p-3 outline-none focus:ring-2 focus:ring-blue-100 border"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Imagem de Capa</label>
                    <input type="file" name="imagem" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer">
                </div>
                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="fixado" id="fixado_new" class="rounded text-blue-600 focus:ring-blue-500">
                    <label for="fixado_new" class="text-sm text-slate-700 font-medium">Fixar no topo do mural</label>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-slate-50">
                <button type="button" onclick="closeModal('modal-novo-aviso')" class="px-6 py-2 text-slate-500 font-bold text-sm uppercase">Cancelar</button>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold text-sm uppercase shadow-lg">Publicar</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDITAR AVISO --}}
<div id="modal-editar-aviso" class="fixed inset-0 bg-slate-900/60 hidden z-50 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden">
        <div class="bg-slate-800 text-white px-6 py-4 flex justify-between items-center">
            <h3 class="font-bold">Editar Publicação</h3>
            <button onclick="closeModal('modal-editar-aviso')" class="text-slate-400 hover:text-white text-2xl">&times;</button>
        </div>
        <form id="form-editar-aviso" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Título</label>
                    <input type="text" name="titulo" id="edit_titulo" required class="w-full border-slate-200 rounded-lg p-3 outline-none border">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Mensagem</label>
                    <textarea name="conteudo" id="edit_conteudo" rows="4" required class="w-full border-slate-200 rounded-lg p-3 outline-none border"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Trocar Capa</label>
                    <input type="file" name="imagem" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer">
                </div>
                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="fixado" id="edit_fixado" class="rounded text-blue-600 focus:ring-blue-500">
                    <label for="edit_fixado" class="text-sm text-slate-700 font-medium">Manter fixado</label>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-slate-50">
                <button type="button" onclick="closeModal('modal-editar-aviso')" class="px-6 py-2 text-slate-500 font-bold text-sm uppercase">Cancelar</button>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold text-sm uppercase shadow-lg">Salvar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); document.body.classList.add('overflow-hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); document.body.classList.remove('overflow-hidden'); }
    function openLikesModal(id) { document.getElementById(id).classList.remove('hidden'); }

    function openEditModal(id, titulo, conteudo, fixado) {
        document.getElementById('edit_titulo').value = titulo;
        document.getElementById('edit_conteudo').value = conteudo;
        document.getElementById('edit_fixado').checked = fixado == 1;
        document.getElementById('form-editar-aviso').action = "{{ route('admin.avisos.index') }}/" + id;
        openModal('modal-editar-aviso');
    }
</script>
@endsection
