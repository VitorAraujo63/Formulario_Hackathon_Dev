<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presença Confirmada</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#F8F9FC] flex items-center justify-center h-screen p-4">

    <div class="bg-white rounded-2xl shadow-xl p-8 max-w-sm w-full text-center border border-slate-100">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
            <i class="fas fa-check text-4xl text-green-600"></i>
        </div>

        <h1 class="text-2xl font-bold text-slate-800 mb-2">Sucesso!</h1>
        <p class="text-slate-500 mb-8">{{ $msg ?? 'Sua presença foi registrada.' }}</p>

        <div class="bg-slate-50 rounded-xl p-4 mb-8 border border-slate-100">
            <p class="text-xs text-slate-400 uppercase font-bold mb-1">Data do Registro</p>
            <p class="font-mono font-bold text-slate-700 text-lg">{{ now()->format('d/m/Y H:i') }}</p>
        </div>

        {{-- LINK CORRIGIDO PARA O DASHBOARD --}}
        <a href="{{ route('aluno.dashboard') }}" class="block w-full bg-slate-900 text-white font-bold py-3.5 rounded-xl hover:bg-black transition shadow-lg hover:shadow-xl hover:-translate-y-0.5">
            Voltar ao Painel
        </a>
    </div>

</body>
</html>
