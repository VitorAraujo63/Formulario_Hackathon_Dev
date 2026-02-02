<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DevMenthors</title>

    {{-- FAVICON --}}
    <link rel="icon" type="image/png" href="{{ asset('img/logos/1.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#F8F9FC] h-screen flex items-center justify-center px-4">

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 w-full max-w-md" x-data="{ tab: 'aluno' }">

        <div class="text-center mb-8">
            {{-- LOGO ATUALIZADA --}}
            <img src="{{ asset('img/logo_rodape.png') }}" alt="DevMenthors" class="h-14 mx-auto mb-4 object-contain">

            <h2 class="text-2xl font-bold text-slate-800">Acesse sua conta</h2>
            <p class="text-slate-400 text-sm mt-1">Escolha seu perfil abaixo para continuar</p>
        </div>

        {{-- ABAS DE SELEÇÃO --}}
        <div class="flex bg-slate-50 p-1 rounded-xl mb-8">
            <button @click="tab = 'aluno'"
                    :class="tab === 'aluno' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                    class="w-1/2 py-2 rounded-lg text-sm font-bold transition-all duration-200 focus:outline-none">
                Sou Aluno
            </button>
            <button @click="tab = 'mentor'"
                    :class="tab === 'mentor' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                    class="w-1/2 py-2 rounded-lg text-sm font-bold transition-all duration-200 focus:outline-none">
                Sou Mentor
            </button>
        </div>

        {{-- FORMULÁRIO ALUNO --}}
        <form x-show="tab === 'aluno'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" action="{{ route('aluno.login.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-slate-500 text-xs font-bold uppercase mb-2">E-mail do Aluno</label>
                <div class="relative">
                    <i class="fas fa-user-graduate absolute left-3 top-3.5 text-slate-400"></i>
                    <input type="email" name="email_aluno" class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition text-slate-700 bg-slate-50 focus:bg-white" placeholder="seu@email.com" required>
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-slate-500 text-xs font-bold uppercase mb-2">Senha</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-3.5 text-slate-400"></i>
                    <input type="password" name="password" class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition text-slate-700 bg-slate-50 focus:bg-white" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition transform hover:-translate-y-0.5">
                Entrar como Aluno
            </button>
        </form>

        {{-- FORMULÁRIO MENTOR --}}
        <form x-show="tab === 'mentor'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" action="{{ route('mentor.login.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-slate-500 text-xs font-bold uppercase mb-2">E-mail Corporativo</label>
                <div class="relative">
                    <i class="fas fa-chalkboard-teacher absolute left-3 top-3.5 text-slate-400"></i>
                    <input type="email" name="email" class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-100 focus:border-slate-500 transition text-slate-700 bg-slate-50 focus:bg-white" placeholder="mentor@devmenthors.com" required>
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-slate-500 text-xs font-bold uppercase mb-2">Senha</label>
                <div class="relative">
                    <i class="fas fa-key absolute left-3 top-3.5 text-slate-400"></i>
                    <input type="password" name="password" class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-slate-100 focus:border-slate-500 transition text-slate-700 bg-slate-50 focus:bg-white" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="w-full bg-slate-800 text-white font-bold py-3 px-4 rounded-xl hover:bg-slate-900 shadow-lg shadow-slate-200 transition transform hover:-translate-y-0.5">
                Entrar como Mentor
            </button>
        </form>

        @if($errors->any())
            <div class="mt-6 p-4 bg-red-50 border border-red-100 text-red-600 rounded-xl text-sm text-center flex items-center justify-center gap-2 animate-pulse">
                <i class="fas fa-exclamation-circle"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <p class="text-center text-xs text-slate-300 mt-8">
            &copy; {{ date('Y') }} DevMenthors Unimar.
        </p>
    </div>

</body>
</html>
