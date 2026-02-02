<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevMenthors | @yield('title')</title>

    {{-- FAVICON --}}
    <link rel="icon" type="image/png" href="{{ asset('img/logos/1.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: {
                            blue: '#007bff',
                            dark: '#1a1d21',
                            gray: '#f3f4f6',
                            text: '#374151'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link.active { background-color: #eff6ff; color: #007bff; border-right: 3px solid #007bff; }
        .sidebar-link:hover:not(.active) { background-color: #f9fafb; }

        /* Transição suave para o menu mobile */
        .sidebar-transition { transition: transform 0.3s ease-in-out; }
    </style>
</head>
<body class="bg-[#F8F9FC] flex h-screen overflow-hidden text-brand-text antialiased">

    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-20 hidden md:hidden glass transition-opacity"></div>

    <aside id="sidebar" class="sidebar-transition fixed md:relative inset-y-0 left-0 z-30 w-64 bg-white border-r border-gray-100 flex flex-col shadow-xl md:shadow-sm transform -translate-x-full md:translate-x-0">

        <div class="h-16 md:h-20 flex items-center justify-between px-6 border-b border-gray-50 shrink-0">
            <div class="flex items-center gap-3">
                {{-- LOGO DESKTOP --}}
                <img src="{{ asset('img/logo_rodape.png') }}" alt="DevMenthors" class="h-10 w-auto object-contain">

                <div>
                    <h1 class="font-bold text-gray-800 text-lg leading-none">DevMenthors</h1>
                    <span class="text-[10px] text-gray-400 uppercase tracking-widest font-semibold">Unimar</span>
                </div>
            </div>
            <button onclick="toggleSidebar()" class="md:hidden text-gray-400 hover:text-red-500">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1">
            <a href="{{ route('mentor.dashboard') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg transition-colors {{ Route::is('mentor.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home w-5 text-center"></i>
                <span class="ml-3">Home</span>
            </a>

            <div class="pt-6 pb-2 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Gestão</div>

            <a href="{{ route('admin.chamada.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg transition-colors {{ Route::is('admin.chamada.*') ? 'active' : '' }}">
                <i class="fas fa-expand w-5 text-center"></i>
                <span class="ml-3">Salas de Aula</span>
            </a>

            <a href="{{ route('admin.aulas.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg transition-colors {{ Route::is('admin.aulas.*') ? 'active' : '' }}">
                <i class="fas fa-folder-open w-5 text-center"></i>
                <span class="ml-3">Conteúdos</span>
            </a>

            <a href="{{ route('admin.avisos.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg transition-colors {{ Route::is('admin.avisos.*') ? 'active' : '' }}">
                <i class="far fa-comment-dots w-5 text-center"></i>
                <span class="ml-3">Mural de Avisos</span>
            </a>

            <div class="pt-6 pb-2 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Admin</div>

            <a href="{{ route('admin.alunos.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg transition-colors {{ Route::is('admin.alunos.*') ? 'active' : '' }}">
                <i class="fas fa-users w-5 text-center"></i>
                <span class="ml-3">Alunos</span>
            </a>

            <a href="{{ route('admin.mentores.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-600 rounded-lg transition-colors {{ Route::is('admin.mentores.*') ? 'active' : '' }}">
                <i class="fas fa-user-shield w-5 text-center"></i>
                <span class="ml-3">Mentores</span>
            </a>
        </nav>

        <div class="p-4 border-t border-gray-50 bg-gray-50/50">
            <a href="{{ route('mentor.perfil') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-white hover:shadow-sm transition group mb-2">
                @php
                    $mLogado = Auth::guard('mentor')->user();
                    // Fallback de imagem caso o user não tenha foto
                    $foto = $mLogado->foto_url ?? "https://ui-avatars.com/api/?name=".urlencode($mLogado->nome)."&background=random";
                @endphp
                <img src="{{ $foto }}" class="w-9 h-9 rounded-full object-cover border border-gray-200">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-700 truncate group-hover:text-blue-600 transition">{{ $mLogado->nome }}</p>
                    <p class="text-xs text-gray-400 truncate">Mentor</p>
                </div>
                <i class="fas fa-cog text-xs text-gray-300"></i>
            </a>

            <form action="{{ route('mentor.logout') }}" method="POST">
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
                {{-- LOGO MOBILE --}}
                <img src="{{ asset('img/logo_rodape.png') }}" alt="DevMenthors" class="h-8 w-auto object-contain">
                <span class="font-bold text-gray-800">DevMenthors</span>
            </div>
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

            // Alterna classes do Tailwind para mostrar/esconder
            if (sidebar.classList.contains('-translate-x-full')) {
                // ABRIR
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                // FECHAR
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
    </script>

</body>
</html>
