<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro no Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#F8F9FC] flex items-center justify-center h-screen p-4">

    <div class="bg-white rounded-2xl shadow-xl p-8 max-w-sm w-full text-center border border-slate-100">
        <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-times text-4xl text-red-500"></i>
        </div>

        <h1 class="text-2xl font-bold text-slate-800 mb-2">Ops!</h1>
        <p class="text-slate-500 mb-6">{{ $msg ?? 'Não foi possível registrar.' }}</p>

        <div class="text-sm text-red-600 bg-red-50 p-4 rounded-xl mb-8 border border-red-100 flex items-start gap-3 text-left">
            <i class="fas fa-exclamation-triangle mt-1"></i>
            <span>O código QR pode ter expirado ou a aula já foi encerrada pelo mentor.</span>
        </div>

        {{-- LINK CORRIGIDO PARA O DASHBOARD --}}
        <a href="{{ route('aluno.dashboard') }}" class="block w-full bg-white border border-slate-200 text-slate-700 font-bold py-3.5 rounded-xl hover:bg-slate-50 transition">
            Tentar Novamente
        </a>
    </div>

</body>
</html>
