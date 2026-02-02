<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Aluno | @yield('title')</title>

    {{-- FAVICON --}}
    <link rel="icon" type="image/png" href="{{ asset('img/logos/1.png') }}">

    {{-- Scripts e Estilos --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: { blue: '#007bff', dark: '#1a1d21', gray: '#f3f4f6' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }

        /* ALTERADO PARA AZUL (Padrão Mentor) */
        .sidebar-link.active {
            background-color: #eff6ff; /* blue-50 */
            color: #2563eb; /* blue-600 */
            border-right: 3px solid #2563eb;
        }

        .sidebar-link:hover:not(.active) { background-color: #f9fafb; }
        .sidebar-transition { transition: transform 0.3s ease-in-out; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#F8F9FC] flex h-screen overflow-hidden text-slate-600 antialiased">

    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-20 hidden md:hidden glass transition-opacity"></div>

    <aside id="sidebar" class="sidebar-transition fixed md:relative inset-y-0 left-0 z-30 w-64 bg-white border-r border-gray-100 flex flex-col shadow-xl md:shadow-sm transform -translate-x-full md:translate-x-0">

        {{-- Header Sidebar --}}
        <div class="h-16 md:h-20 flex items-center justify-between px-6 border-b border-gray-50 shrink-0">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/logo_rodape.png') }}" alt="DevMenthors" class="h-10 w-auto object-contain">
                <div>
                    <h1 class="font-bold text-gray-800 text-lg leading-none">DevMenthors</h1>
                    {{-- Alterado para Blue --}}
                    <span class="text-[10px] text-blue-600 uppercase tracking-widest font-bold">Unimar</span>
                </div>
            </div>
            <button onclick="toggleSidebar()" class="md:hidden text-gray-400 hover:text-red-500">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        {{-- Menu de Navegação --}}
        <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1">
            <a href="{{ route('aluno.dashboard') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg transition-colors {{ Route::is('aluno.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home w-5 text-center"></i>
                <span class="ml-3">Início</span>
            </a>

            <div class="pt-6 pb-2 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Acadêmico</div>

            <a href="{{ route('aluno.avisos.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg transition-colors {{ Route::is('aluno.avisos.*') ? 'active' : '' }}">
                <i class="fas fa-bullhorn w-5 text-center"></i>
                <span class="ml-3">Mural de Avisos</span>
            </a>

            <a href="{{ route('aluno.materiais') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg transition-colors {{ Route::is('aluno.materiais') ? 'active' : '' }}">
                <i class="fas fa-book-open w-5 text-center"></i>
                <span class="ml-3">Materiais de Aula</span>
            </a>

            <a href="{{ route('aluno.frequencia') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg transition-colors {{ Route::is('aluno.frequencia') ? 'active' : '' }}">
                <i class="fas fa-history w-5 text-center"></i>
                <span class="ml-3">Minha Frequência</span>
            </a>
        </nav>

        {{-- Footer Sidebar (Perfil) --}}
        <div class="p-4 border-t border-gray-50 bg-gray-50/50">
            {{-- LINK PARA O PERFIL --}}
            <a href="{{ route('aluno.perfil') }}" class="flex items-center gap-3 p-2 rounded-lg mb-2 hover:bg-white transition group cursor-pointer">

                @php
                    $aluno = Auth::guard('aluno')->user();
                @endphp

                {{-- FOTO --}}
                @if($aluno->foto)
                    {{-- Borda azul --}}
                    <img src="{{ route('aluno.foto.proxy', basename($aluno->foto)) }}" class="w-9 h-9 rounded-full object-cover border border-blue-200">
                @else
                    {{-- Iniciais com fundo Azul --}}
                    <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm border border-blue-100">
                        {{ substr($aluno->nome_completo, 0, 2) }}
                    </div>
                @endif

                <div class="flex-1 min-w-0">
                    {{-- Texto Hover Azul --}}
                    <p class="text-sm font-bold text-gray-700 truncate group-hover:text-blue-600 transition">{{ $aluno->nome_completo }}</p>
                    <p class="text-xs text-gray-400 truncate">Ver Perfil</p>
                </div>
                <i class="fas fa-chevron-right text-[10px] text-gray-300 group-hover:text-blue-500"></i>
            </a>

            <form action="{{ route('aluno.logout') }}" method="POST">
                @csrf
                <button class="w-full flex items-center justify-center gap-2 text-xs font-bold text-red-400 py-2 hover:bg-red-50 rounded transition border border-transparent hover:border-red-100">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <header class="md:hidden h-16 bg-white border-b border-gray-100 flex items-center justify-between px-4 shrink-0 z-10">
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/logo_rodape.png') }}" alt="DevMenthors" class="h-8 w-auto object-contain">
                <span class="font-bold text-gray-800">Aluno</span>
            </div>
            {{-- Hover Azul no Mobile --}}
            <button onclick="toggleSidebar()" class="text-gray-500 hover:text-blue-600 p-2">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </header>

        <main class="flex-1 overflow-y-auto overflow-x-hidden p-4 md:p-8 custom-scrollbar">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
