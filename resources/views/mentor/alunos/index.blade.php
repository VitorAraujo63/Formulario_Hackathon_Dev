@extends('layouts.mentor')

@section('title', 'Gestão de Alunos')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">

    {{-- Header com botões responsivos --}}
    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center mb-8 gap-4 xl:gap-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">Base de Alunos</h1>
            <p class="text-slate-500 mt-1 text-sm md:text-base">Gerencie matrículas, dados cadastrais e histórico.</p>
        </div>

        <div class="flex flex-col sm:flex-row flex-wrap gap-3 w-full xl:w-auto">
            {{-- Grupo de Botões (Full width no mobile) --}}
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 flex flex-col sm:flex-row overflow-hidden w-full sm:w-auto">
                <a href="{{ route('admin.alunos.template') }}" class="px-4 py-3 sm:py-2 text-slate-600 hover:bg-slate-50 border-b sm:border-b-0 sm:border-r border-slate-100 text-sm font-medium transition flex items-center justify-center sm:justify-start gap-2">
                    <i class="fas fa-download text-slate-400"></i> Modelo
                </a>
                <button onclick="openModal('modal-importar')" class="px-4 py-3 sm:py-2 text-slate-600 hover:bg-slate-50 border-b sm:border-b-0 sm:border-r border-slate-100 text-sm font-medium transition flex items-center justify-center sm:justify-start gap-2">
                    <i class="fas fa-file-import text-slate-400"></i> Importar
                </button>
                <a href="{{ route('admin.alunos.export') }}" class="px-4 py-3 sm:py-2 text-green-600 hover:bg-green-50 text-sm font-medium transition flex items-center justify-center sm:justify-start gap-2">
                    <i class="fas fa-file-excel"></i> Exportar
                </a>
            </div>

            <button onclick="openModal('modal-novo-aluno')" class="bg-blue-600 text-white px-5 py-3 sm:py-2 rounded-lg hover:bg-blue-700 shadow-lg shadow-blue-200 flex items-center justify-center gap-2 transition font-semibold w-full sm:w-auto">
                <i class="fas fa-plus"></i> Novo Aluno
            </button>
        </div>
    </div>

    {{-- Stats Cards (Grid responsivo) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 border-l-4 border-l-blue-500">
            <h3 class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Inscritos</h3>
            <p class="text-3xl font-black text-slate-800 mt-2">{{ $totalAlunos ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 border-l-4 border-l-green-500">
            <h3 class="text-slate-400 text-xs font-bold uppercase tracking-wider">Com Experiência</h3>
            <p class="text-3xl font-black text-slate-800 mt-2">{{ $totalComConhecimento ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 border-l-4 border-l-amber-500">
            <h3 class="text-slate-400 text-xs font-bold uppercase tracking-wider">Última Matrícula</h3>
            <p class="text-lg font-bold text-slate-800 mt-3 truncate">{{ $ultimoInscrito ?? 'Ninguém' }}</p>
        </div>
    </div>

    {{-- Tabela com Scroll --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="p-5 text-xs font-bold text-slate-500 uppercase tracking-wider">Aluno / Série</th>
                        <th class="p-5 text-xs font-bold text-slate-500 uppercase tracking-wider">Responsável</th>
                        <th class="p-5 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Conhecimento</th>
                        <th class="p-5 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($alunos as $aluno)
                    <tr class="hover:bg-slate-50/50 transition group">
                        <td class="p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm">
                                    {{ substr($aluno->nome_completo, 0, 2) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800">{{ $aluno->nome_completo }}</div>
                                    <div class="text-xs text-slate-500">
                                        {{ str_replace(['_ano', '_em'], ['º Ano', 'ª Série'], $aluno->serie) }} • {{ $aluno->escola }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="p-5">
                            <div class="text-sm font-medium text-slate-700">{{ $aluno->nome_responsavel }}</div>
                            <a href="https://wa.me/55{{ preg_replace('/\D/', '', $aluno->telefone_responsavel) }}"
                               target="_blank"
                               class="text-xs text-green-600 hover:text-green-700 font-medium flex items-center gap-1 mt-1 w-fit">
                               <i class="fab fa-whatsapp"></i> {{ $aluno->telefone_responsavel }}
                            </a>
                        </td>

                        <td class="p-5 text-center">
                            @if($aluno->tem_conhecimento_previo)
                                <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-1 rounded-full uppercase">Sim</span>
                            @else
                                <span class="bg-slate-100 text-slate-500 text-[10px] font-bold px-2 py-1 rounded-full uppercase">Não</span>
                            @endif
                        </td>

                        <td class="p-5 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-100 xl:opacity-0 group-hover:opacity-100 transition-opacity">
                                <button type="button"
                                        onclick="openEditModal(this)"
                                        data-id="{{ $aluno->id }}"
                                        data-nome="{{ $aluno->nome_completo }}"
                                        data-nascimento="{{ $aluno->data_nascimento instanceof \DateTime ? $aluno->data_nascimento->format('Y-m-d') : $aluno->data_nascimento }}"
                                        data-email="{{ $aluno->email_aluno }}"
                                        data-escola="{{ $aluno->escola }}"
                                        data-serie="{{ $aluno->serie }}"
                                        data-responsavel="{{ $aluno->nome_responsavel }}"
                                        data-email-resp="{{ $aluno->email_responsavel }}"
                                        data-tel-resp="{{ $aluno->telefone_responsavel }}"
                                        data-tel-aluno="{{ $aluno->telefone_aluno }}"
                                        class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center transition" title="Editar">
                                    <i class="fas fa-pencil-alt text-xs"></i>
                                </button>

                                <form action="{{ route('admin.alunos.destroy', $aluno->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este aluno?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-full bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition" title="Excluir">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center text-slate-400">
                            <i class="far fa-folder-open text-4xl mb-3 block opacity-50"></i>
                            Nenhum aluno encontrado na base.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAIS RESPONSIVOS --}}

{{-- 1. Modal Novo Aluno --}}
<div id="modal-novo-aluno" class="fixed inset-0 bg-slate-900/60 hidden z-50 flex items-center justify-center backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 overflow-hidden flex flex-col max-h-[90vh]">
        <div class="bg-slate-800 text-white px-6 py-4 flex justify-between items-center shrink-0">
            <h3 class="text-lg font-bold">Cadastrar Novo Aluno</h3>
            <button onclick="closeModal('modal-novo-aluno')" class="text-slate-400 hover:text-white text-2xl">&times;</button>
        </div>
        {{-- Adicionado overflow-y-auto no form para rolar em telas pequenas --}}
        <form action="{{ route('aluno.store') }}" method="POST" class="p-6 overflow-y-auto">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nome Completo</label>
                    <input type="text" name="nome_completo" required class="w-full border-slate-200 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 border outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" required class="w-full border-slate-200 rounded-lg p-2.5 border outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">E-mail</label>
                    <input type="email" name="email_aluno" class="w-full border-slate-200 rounded-lg p-2.5 border outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Escola</label>
                    <input type="text" name="escola" required class="w-full border-slate-200 rounded-lg p-2.5 border outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Série</label>
                    <select name="serie" class="w-full border-slate-200 rounded-lg p-2.5 border outline-none bg-white">
                        <option value="9_ano">9º Ano</option>
                        <option value="1_em">1ª Série EM</option>
                        <option value="2_em">2ª Série EM</option>
                        <option value="3_em">3ª Série EM</option>
                    </select>
                </div>

                <div class="col-span-1 md:col-span-2 mt-4 border-t pt-4">
                    <h4 class="text-sm font-bold text-blue-600 mb-4 uppercase tracking-wide">Dados do Responsável</h4>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nome Responsável</label>
                    <input type="text" name="nome_responsavel" required class="w-full border-slate-200 rounded-lg p-2.5 border outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">WhatsApp</label>
                    <input type="text" name="telefone_responsavel" required class="w-full border-slate-200 rounded-lg p-2.5 border outline-none">
                </div>
                 <div class="col-span-1 md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Email Responsável</label>
                    <input type="email" name="email_responsavel" required class="w-full border-slate-200 rounded-lg p-2.5 border outline-none">
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-4 border-t border-slate-50">
                <button type="button" onclick="closeModal('modal-novo-aluno')" class="w-full sm:w-auto px-6 py-3 sm:py-2 text-slate-500 hover:text-slate-700 font-bold text-sm uppercase">Cancelar</button>
                <button type="submit" class="w-full sm:w-auto px-6 py-3 sm:py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold text-sm uppercase shadow-lg shadow-blue-200">Salvar Aluno</button>
            </div>
        </form>
    </div>
</div>

{{-- 2. Modal Editar Aluno (Responsivo) --}}
<div id="modal-editar-aluno" class="fixed inset-0 bg-slate-900/60 hidden z-50 flex items-center justify-center backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 overflow-hidden flex flex-col max-h-[90vh]">
        <div class="bg-slate-800 text-white px-6 py-4 flex justify-between items-center shrink-0">
            <h3 class="text-lg font-bold">Editar Aluno</h3>
            <button onclick="closeModal('modal-editar-aluno')" class="text-slate-400 hover:text-white text-2xl">&times;</button>
        </div>
        <form id="form-editar" method="POST" class="p-6 overflow-y-auto">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                 <div class="col-span-1 md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nome Completo</label>
                    <input type="text" name="nome_completo" id="edit_nome" required class="w-full border-slate-200 rounded-lg p-2.5 border outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" id="edit_nascimento" required class="w-full border-slate-200 rounded-lg p-2.5 border outline-none">
                </div>
                 <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">E-mail</label>
                    <input type="email" name="email_aluno" id="edit_email" class="w-full border-slate-200 rounded-lg p-2.5 border outline-none">
                </div>
                 <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Escola</label>
                    <input type="text" name="escola" id="edit_escola" required class="w-full border-slate-200 rounded-lg p-2.5 border outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Série</label>
                    <select name="serie" id="edit_serie" class="w-full border-slate-200 rounded-lg p-2.5 border outline-none bg-white">
                        <option value="9_ano">9º Ano</option>
                        <option value="1_em">1ª Série EM</option>
                        <option value="2_em">2ª Série EM</option>
                        <option value="3_em">3ª Série EM</option>
                    </select>
                </div>
                <div class="col-span-1 md:col-span-2 mt-4 border-t pt-4">
                    <h4 class="text-sm font-bold text-blue-600 mb-4 uppercase tracking-wide">Dados do Responsável</h4>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nome Responsável</label>
                    <input type="text" name="nome_responsavel" id="edit_responsavel" required class="w-full border-slate-200 rounded-lg p-2.5 border outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">WhatsApp</label>
                    <input type="text" name="telefone_responsavel" id="edit_tel_resp" required class="w-full border-slate-200 rounded-lg p-2.5 border outline-none">
                </div>
                 <div class="col-span-1 md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Email Responsável</label>
                    <input type="email" name="email_responsavel" id="edit_email_resp" required class="w-full border-slate-200 rounded-lg p-2.5 border outline-none">
                </div>
            </div>
             <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-4 border-t border-slate-50">
                <button type="button" onclick="closeModal('modal-editar-aluno')" class="w-full sm:w-auto px-6 py-3 sm:py-2 text-slate-500 hover:text-slate-700 font-bold text-sm uppercase">Cancelar</button>
                <button type="submit" class="w-full sm:w-auto px-6 py-3 sm:py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-bold text-sm uppercase shadow-lg">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>

{{-- 3. Modal Importar (Responsivo) --}}
<div id="modal-importar" class="fixed inset-0 bg-slate-900/60 hidden z-50 flex items-center justify-center backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden flex flex-col max-h-[90vh]">
        <div class="bg-slate-800 text-white px-6 py-4 flex justify-between items-center shrink-0">
            <h3 class="text-lg font-bold">Importar Base</h3>
            <button onclick="closeModal('modal-importar')" class="text-slate-400 hover:text-white text-2xl">&times;</button>
        </div>
        <form action="{{ route('admin.alunos.import') }}" method="POST" enctype="multipart/form-data" class="p-6 overflow-y-auto">
            @csrf
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-green-50 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 border border-green-100">
                    <i class="fas fa-file-excel text-3xl"></i>
                </div>
                <h4 class="font-bold text-slate-700">Upload de Arquivo</h4>
                <p class="text-slate-400 text-sm mt-1">Aceita formatos .xlsx ou .csv</p>
            </div>
            <input type="file" name="arquivo" required class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-8">
                <button type="button" onclick="closeModal('modal-importar')" class="w-full sm:w-auto px-4 py-3 sm:py-2 text-slate-500 font-bold text-sm">Cancelar</button>
                <button type="submit" class="w-full sm:w-auto px-6 py-3 sm:py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-bold text-sm shadow-lg shadow-green-200">Importar Agora</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); document.body.classList.add('overflow-hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); document.body.classList.remove('overflow-hidden'); }

    function openEditModal(button) {
        const data = button.dataset;
        document.getElementById('edit_nome').value = data.nome;
        document.getElementById('edit_nascimento').value = data.nascimento;
        document.getElementById('edit_email').value = data.email;
        document.getElementById('edit_escola').value = data.escola;
        document.getElementById('edit_serie').value = data.serie;
        document.getElementById('edit_responsavel').value = data.responsavel;
        document.getElementById('edit_email_resp').value = data.emailResp;
        document.getElementById('edit_tel_resp').value = data.telResp;

        const form = document.getElementById('form-editar');
        form.action = "{{ route('admin.alunos.index') }}/" + data.id;

        openModal('modal-editar-aluno');
    }
</script>
@endsection
