@extends('layouts.mentor')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    {{-- Cabeçalho Responsivo --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Conteúdos e Atividades</h1>
            <p class="text-gray-500 text-sm">Organize materiais, links do Canva e PDFs para as aulas.</p>
        </div>
        <button onclick="openCreateModal()" class="w-full md:w-auto bg-slate-800 text-white px-6 py-2 rounded-lg shadow-lg hover:bg-slate-900 transition flex items-center justify-center gap-2 font-bold">
            <i class="fas fa-plus"></i> Nova Aula
        </button>
    </div>

    {{-- Grid de Aulas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        @forelse($aulas as $aula)
            <div class="bg-white border rounded-xl shadow-sm overflow-hidden flex flex-col hover:shadow-md transition">
                <div class="p-5 flex-1">
                    <div class="flex justify-between items-start mb-3">
                        <span class="text-[10px] font-bold px-2 py-1 bg-blue-100 text-blue-700 rounded-md uppercase tracking-wider">
                            {{ $aula->categoria->nome ?? 'Geral' }}
                        </span>
                        <div class="flex items-center gap-2">
                            @if($aula->publicada)
                                <span class="text-[10px] font-bold text-green-600 bg-green-50 px-2 py-1 rounded-md border border-green-100">
                                    <i class="fas fa-eye"></i> LIBERADA
                                </span>
                            @else
                                <span class="text-[10px] font-bold text-amber-500 bg-amber-50 px-2 py-1 rounded-md border border-amber-100">
                                    <i class="fas fa-eye-slash"></i> OCULTA
                                </span>
                            @endif
                        </div>
                    </div>

                    <h3 class="font-bold text-lg text-slate-800 mb-1 leading-tight">{{ $aula->titulo }}</h3>
                    <p class="text-xs text-gray-500 line-clamp-2 mb-4">{{ $aula->descricao ?? 'Sem descrição.' }}</p>

                    <div class="space-y-2 mt-4">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Materiais</p>
                        @foreach($aula->recursos as $recurso)
                            <div class="flex items-center justify-between bg-gray-50 p-2 rounded-lg border border-gray-100 group">
                                <div class="flex items-center gap-2 overflow-hidden">
                                    @if($recurso->tipo == 'arquivo')
                                        <i class="fas fa-file-pdf text-red-500 text-sm"></i>
                                    @elseif(Str::contains($recurso->path, 'github.com'))
                                        <i class="fab fa-github text-slate-800 text-sm"></i>
                                    @elseif(Str::contains($recurso->path, 'canva.com'))
                                        <i class="fas fa-palette text-blue-400 text-sm"></i>
                                    @else
                                        <i class="fas fa-link text-blue-500 text-sm"></i>
                                    @endif
                                    <span class="text-xs text-gray-700 truncate font-medium">{{ $recurso->titulo }}</span>
                                </div>
                                <a href="{{ $recurso->tipo == 'arquivo' ? 'http://72.60.8.197:8888/buckets/mentoria/'.$recurso->path : $recurso->path }}"
                                   target="_blank" class="text-slate-400 hover:text-slate-800 transition">
                                    <i class="fas fa-external-link-alt text-xs"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-slate-50 p-4 border-t flex justify-between items-center">
                    <span class="text-[11px] font-bold text-slate-400">
                        <i class="far fa-calendar-alt mr-1"></i> {{ $aula->data_prevista ? date('d/m/Y', strtotime($aula->data_prevista)) : 'Data não definida' }}
                    </span>
                    <div class="flex gap-1">
                        <button onclick='openEditModal({!! json_encode($aula) !!})' class="text-gray-400 hover:text-blue-600 transition p-2">
                            <i class="fas fa-edit text-sm"></i>
                        </button>
                        <form action="{{ route('admin.aulas.destroy', $aula->id) }}" method="POST" onsubmit="return confirm('Deseja excluir esta aula permanentemente?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-500 transition p-2">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white border-2 border-dashed rounded-2xl py-16 text-center shadow-sm">
                <i class="fas fa-book-open text-3xl text-slate-300 mb-4 block"></i>
                <p class="text-slate-500 font-medium">Nenhuma aula cadastrada ainda.</p>
            </div>
        @endforelse
    </div>

    {{-- Modal Dinâmico (Responsivo) --}}
    <div id="modal-aula" class="fixed inset-0 bg-slate-900/60 hidden z-50 flex items-center justify-center backdrop-blur-sm p-4">
        <div class="bg-white rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="bg-slate-800 px-6 py-4 flex justify-between items-center shrink-0">
                <h2 id="modal-title" class="text-lg font-bold text-white">Configurar Nova Aula</h2>
                <button onclick="closeModal('modal-aula')" class="text-slate-400 hover:text-white transition text-2xl">&times;</button>
            </div>

            <form id="form-aula" action="{{ route('admin.aulas.store') }}" method="POST" enctype="multipart/form-data" class="p-6 overflow-y-auto">
                @csrf
                <div id="method-spoofing"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Título</label>
                        <input type="text" name="titulo" id="input_titulo" required class="w-full border rounded-lg p-2.5 outline-none focus:ring-2 focus:ring-slate-200">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Categoria</label>
                        <select name="aula_categoria_id" id="input_categoria" class="w-full border rounded-lg p-2.5 outline-none">
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Data Prevista</label>
                        <input type="date" name="data_prevista" id="input_data" class="w-full border rounded-lg p-2.5 outline-none">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Descrição</label>
                        <textarea name="descricao" id="input_descricao" rows="2" class="w-full border rounded-lg p-2.5 outline-none"></textarea>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-100">
                    <label id="label-upload" class="block text-xs font-black text-blue-700 uppercase tracking-widest mb-2">Upload de Arquivos</label>
                    <input type="file" name="arquivos[]" multiple class="text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-600 file:text-white cursor-pointer">
                </div>

                <div class="mt-6" id="links-container">
                    <label class="block text-xs font-black text-purple-700 uppercase tracking-widest mb-2">Links Externos</label>
                    <div class="flex gap-2 mb-2">
                        <input type="text" name="link_titulos[]" placeholder="Nome (Ex: Canva)" class="w-1/3 border rounded-lg p-2 text-sm">
                        <input type="url" name="links[]" placeholder="https://..." class="w-2/3 border rounded-lg p-2 text-sm">
                    </div>
                </div>
                <button type="button" onclick="addLinkField()" class="text-[10px] font-black text-purple-600 uppercase tracking-widest">+ Adicionar outro link</button>

                <div class="mt-8 pt-6 border-t flex flex-col md:flex-row justify-between items-center gap-4">
                    <label class="flex items-center gap-2 cursor-pointer w-full md:w-auto">
                        <input type="checkbox" name="publicada" id="input_publicada" value="1" class="w-4 h-4 rounded text-blue-600">
                        <span class="text-sm font-bold text-slate-600">Liberar para alunos</span>
                    </label>

                    <div class="flex gap-3 w-full md:w-auto">
                        <button type="button" onclick="closeModal('modal-aula')" class="flex-1 md:flex-none px-6 py-2 text-sm font-bold text-slate-400">Cancelar</button>
                        <button type="submit" id="btn-save" class="flex-1 md:flex-none bg-slate-800 text-white px-8 py-2 rounded-lg font-bold shadow-lg hover:bg-slate-900 transition text-sm">SALVAR AULA</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCreateModal() {
        resetModal();
        document.getElementById('modal-title').innerText = "Configurar Nova Aula";
        document.getElementById('modal-aula').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function openEditModal(aula) {
        resetModal();
        document.getElementById('modal-title').innerText = "Editar Aula";
        document.getElementById('btn-save').innerText = "ATUALIZAR AULA";
        document.getElementById('label-upload').innerText = "Adicionar novos materiais (os antigos permanecem)";

        document.getElementById('input_titulo').value = aula.titulo;
        document.getElementById('input_categoria').value = aula.aula_categoria_id;
        document.getElementById('input_descricao').value = aula.descricao || '';
        document.getElementById('input_publicada').checked = !!aula.publicada;

        if(aula.data_prevista) {
            document.getElementById('input_data').value = aula.data_prevista;
        }

        let form = document.getElementById('form-aula');
        form.action = "{{ route('admin.aulas.index') }}/" + aula.id;
        document.getElementById('method-spoofing').innerHTML = '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('modal-aula').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function resetModal() {
        let form = document.getElementById('form-aula');
        form.reset();
        form.action = "{{ route('admin.aulas.store') }}";
        document.getElementById('method-spoofing').innerHTML = '';
        document.getElementById('btn-save').innerText = "SALVAR AULA";
        document.getElementById('label-upload').innerText = "Upload de Arquivos";
    }

    function addLinkField() {
        const container = document.getElementById('links-container');
        const div = document.createElement('div');
        div.className = 'flex gap-2 mb-2';
        div.innerHTML = `<input type="text" name="link_titulos[]" placeholder="Nome" class="w-1/3 border rounded-lg p-2 text-sm"><input type="url" name="links[]" placeholder="https://..." class="w-2/3 border rounded-lg p-2 text-sm">`;
        container.appendChild(div);
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
@endsection
