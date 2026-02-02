@extends('layouts.mentor')

@section('title', 'Chamada em Tempo Real')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

{{--
    ESTRUTURA PRINCIPAL
    Mobile: Altura automática (rola a página)
    Desktop: Altura fixa calculada (100vh - header), sem rolagem na página, apenas nos elementos internos
--}}
<div class="flex flex-col lg:flex-row gap-6 h-auto lg:h-[calc(100vh-6rem)] pb-10 lg:pb-0">

    <div class="flex-1 bg-white rounded-3xl shadow-sm border border-slate-100 flex flex-col items-center justify-center p-6 relative overflow-hidden order-1">

        {{-- Fundo decorativo sutil --}}
        <div class="absolute inset-0 bg-slate-50/30 pattern-grid -z-10"></div>

        <div class="z-10 text-center w-full max-w-md flex flex-col items-center">

            <div class="mb-6">
                <span class="bg-blue-100 text-blue-700 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest mb-2 inline-block">
                    Ao Vivo
                </span>
                <h2 class="text-4xl font-black text-slate-800 leading-none mt-1">SALA {{ $chamada->codigo_acesso }}</h2>
            </div>

            <div class="relative bg-white p-4 rounded-3xl shadow-xl shadow-slate-200 border border-slate-100 inline-block mb-6">
                <div id="qrcode-normal" class="flex justify-center"></div>
            </div>

            <div class="w-64 bg-slate-100 h-1.5 rounded-full overflow-hidden mb-8">
                <div id="progress-bar" class="h-full bg-blue-600 w-full rounded-full"></div>
            </div>

            <button onclick="ativarModoTelao()" class="hidden lg:flex bg-slate-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-black transition items-center gap-2 text-xs uppercase tracking-widest shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                <i class="fas fa-expand"></i> Modo Telão
            </button>
        </div>
    </div>

    <div class="w-full lg:w-96 bg-white rounded-3xl shadow-sm border border-slate-100 flex flex-col overflow-hidden order-2 h-[500px] lg:h-full">

        <div class="p-5 border-b border-slate-50 flex justify-between items-center bg-slate-50/50 shrink-0">
            <div>
                <h3 class="font-bold text-slate-800">Presenças</h3>
                <p class="text-xs text-slate-400 font-medium">Tempo Real</p>
            </div>
            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-xs font-bold shadow-sm border border-green-200" id="contador">0</span>
        </div>

        {{-- Área de Scroll --}}
        <div class="flex-1 overflow-y-auto p-3 space-y-2 custom-scrollbar relative" id="lista-presenca">
            <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-300" id="empty-state">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                    <i class="fas fa-user-clock text-2xl text-slate-300"></i>
                </div>
                <p class="text-xs font-medium">Aguardando alunos...</p>
            </div>
        </div>

        <div class="p-4 border-t border-slate-50 bg-slate-50/30 space-y-2 shrink-0">
            <button onclick="openModal('modal-manual')" class="w-full bg-white border border-blue-200 text-blue-600 py-3 rounded-xl hover:bg-blue-50 transition text-xs font-bold uppercase tracking-wide shadow-sm">
                + Adicionar Manual
            </button>
            <form action="{{ route('admin.chamada.encerrar', $chamada->id) }}" method="POST">
                @csrf
                <button class="w-full bg-red-50 text-red-500 py-3 rounded-xl hover:bg-red-100 transition text-xs font-bold uppercase tracking-wide">
                    Encerrar Aula
                </button>
            </form>
        </div>
    </div>
</div>

{{--
    OVERLAY MODO TELÃO (Imersivo)
    Fica por cima de tudo (z-50), fundo escuro com blur
--}}
<div id="telao-overlay" class="hidden fixed inset-0 z-[100] bg-slate-900/95 backdrop-blur-md flex flex-col items-center justify-center transition-opacity duration-500">
    <button onclick="desativarModoTelao()" class="absolute top-8 right-8 text-white/50 hover:text-white transition p-4">
        <i class="fas fa-times text-4xl"></i>
    </button>

    <div class="text-center animate-scaleIn">
        <h1 class="text-white text-5xl font-black mb-2 tracking-tight">SALA {{ $chamada->codigo_acesso }}</h1>
        <p class="text-slate-400 text-xl mb-10 font-light">Aponte a câmera para registrar sua presença</p>

        <div class="bg-white p-6 rounded-3xl shadow-2xl inline-block">
            <div id="qrcode-telao"></div>
        </div>

        <div class="mt-8 text-slate-500 text-sm font-mono">Atualizando token de segurança...</div>
    </div>
</div>

{{-- MODAL MANUAL (Incorporado) --}}
<div id="modal-manual" class="fixed inset-0 bg-slate-900/60 hidden z-50 flex items-center justify-center backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden flex flex-col max-h-[80vh]">
        <div class="p-4 border-b flex justify-between items-center bg-slate-50">
            <h3 class="font-bold text-slate-800">Buscar Aluno</h3>
            <button onclick="closeModal('modal-manual')" class="text-slate-400 hover:text-red-500 text-xl">&times;</button>
        </div>
        <div class="p-4">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-3 text-slate-400"></i>
                <input type="text" id="search-input" class="w-full pl-10 pr-4 py-3 border rounded-lg outline-none bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-100 transition" placeholder="Digite o nome..." autocomplete="off">
            </div>
        </div>
        <div id="search-results" class="flex-1 overflow-y-auto p-2 space-y-1 bg-white min-h-[200px]">
            <p class="text-center text-slate-400 text-sm py-4">Digite para buscar...</p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chamadaId = "{{ $chamada->id }}";
        const baseUrlRegistro = "{{ route('aluno.presenca.registrar', $chamada->id) }}";

        const TEMPO_QR_CODE = 10000;
        const TEMPO_LISTA = 1500;

        // Seleciona os dois containers
        const qrContainerNormal = document.getElementById("qrcode-normal");
        const qrContainerTelao = document.getElementById("qrcode-telao");

        let lastQrCode = "";

        // --- 1. GERAÇÃO DOS QR CODES ---
        function updateQRCode() {
            fetch(`/admin/chamada/qr/${chamadaId}`)
                .then(res => res.json())
                .then(data => {
                    if (data && data.qr_code && data.qr_code !== lastQrCode) {
                        // Limpa ambos
                        qrContainerNormal.innerHTML = "";
                        qrContainerTelao.innerHTML = "";

                        const urlCompleta = baseUrlRegistro + "?token=" + data.qr_code;

                        // 1. Normal (256px)
                        new QRCode(qrContainerNormal, {
                            text: urlCompleta,
                            width: 256, height: 256,
                            colorDark : "#1e293b", colorLight : "#ffffff",
                            correctLevel : QRCode.CorrectLevel.L // L é mais rápido de ler
                        });

                        // 2. Telão (450px - Bem grande!)
                        new QRCode(qrContainerTelao, {
                            text: urlCompleta,
                            width: 450, height: 450,
                            colorDark : "#000000", colorLight : "#ffffff",
                            correctLevel : QRCode.CorrectLevel.L
                        });

                        lastQrCode = data.qr_code;
                        resetProgressBar();
                    }
                }).catch(console.error);
        }

        function resetProgressBar() {
            let bar = document.getElementById('progress-bar');
            if(bar) {
                bar.style.transition = 'none';
                bar.style.width = '100%';
                void bar.offsetWidth;
                bar.style.transition = `width ${TEMPO_QR_CODE}ms linear`;
                bar.style.width = '0%';
            }
        }

        // --- 2. LISTA SEM PISCAR ---
        function updatePresencas() {
            fetch(`/admin/chamada/lista/${chamadaId}`)
                .then(res => res.json())
                .then(data => {
                    const contador = document.getElementById("contador");
                    if(contador) contador.innerText = data.total || 0;

                    const lista = document.getElementById("lista-presenca");
                    const emptyState = document.getElementById("empty-state");

                    if (data.alunos && data.alunos.length > 0) {
                        if(emptyState) emptyState.style.display = 'none';

                        data.alunos.forEach(aluno => {
                            const cardExistente = document.getElementById(`aluno-${aluno.id}`);
                            if (!cardExistente) {
                                const cardHTML = `
                                    <div id="aluno-${aluno.id}" class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100 animate-slideDown transition-all hover:bg-slate-50">
                                        <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold shadow-sm shrink-0">
                                            ${aluno.avatar}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-slate-700 truncate">${aluno.nome}</p>
                                            <p class="text-[10px] text-slate-400 font-medium">${aluno.horario}</p>
                                        </div>
                                        <i class="fas fa-check-circle text-green-500 shrink-0"></i>
                                    </div>
                                `;
                                lista.insertAdjacentHTML('afterbegin', cardHTML);
                            }
                        });
                    } else {
                        if(emptyState) emptyState.style.display = 'flex';
                    }
                })
                .catch(err => console.error("Erro lista:", err));
        }

        setInterval(updateQRCode, TEMPO_QR_CODE);
        setInterval(updatePresencas, TEMPO_LISTA);
        updateQRCode();
        updatePresencas();
    });

    // --- MODO TELÃO ---
    function ativarModoTelao() {
        const overlay = document.getElementById('telao-overlay');
        overlay.classList.remove('hidden');
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        }
    }

    function desativarModoTelao() {
        const overlay = document.getElementById('telao-overlay');
        overlay.classList.add('hidden');
        if (document.exitFullscreen) {
            document.exitFullscreen();
        }
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === "Escape") desativarModoTelao();
    });

    // --- GLOBAIS ---
    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

    // --- BUSCA MANUAL ---
    const searchInput = document.getElementById('search-input');
    const resultsContainer = document.getElementById('search-results');
    let debounceTimer;

    if(searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const query = this.value;
            if (query.length < 2) {
                resultsContainer.innerHTML = '<p class="text-center text-slate-400 text-sm py-4">Digite para buscar...</p>';
                return;
            }
            debounceTimer = setTimeout(() => {
                fetch(`{{ route('admin.chamada.alunos.search') }}?q=${query}`)
                    .then(res => res.json())
                    .then(alunos => {
                        if (alunos.length === 0) {
                            resultsContainer.innerHTML = '<p class="text-center text-slate-400 text-sm py-4">Nenhum aluno encontrado.</p>';
                        } else {
                            resultsContainer.innerHTML = alunos.map(aluno => `
                                <button onclick="confirmarPresencaManual(${aluno.id}, '${aluno.nome_completo}')"
                                    class="w-full text-left p-3 hover:bg-blue-50 rounded-lg flex items-center justify-between group transition border-b border-slate-50 last:border-0">
                                    <span class="font-bold text-slate-700 text-sm group-hover:text-blue-700">${aluno.nome_completo}</span>
                                    <i class="fas fa-plus text-slate-300"></i>
                                </button>
                            `).join('');
                        }
                    });
            }, 300);
        });
    }

    function confirmarPresencaManual(alunoId, nomeAluno) {
        if(!confirm(`Confirmar ${nomeAluno}?`)) return;
        fetch(`/admin/chamada/manual/{{ $chamada->id }}`, {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({ aluno_id: alunoId })
        }).then(res => res.json()).then(data => {
            alert(data.message || 'Sucesso!');
            closeModal('modal-manual');
            searchInput.value = '';
            resultsContainer.innerHTML = '';
        });
    }
</script>

<style>
    @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-slideDown { animation: slideDown 0.4s ease-out forwards; }

    @keyframes scaleIn { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    .animate-scaleIn { animation: scaleIn 0.3s ease-out forwards; }

    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }

    .pattern-grid { background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 20px 20px; }
</style>
@endsection
