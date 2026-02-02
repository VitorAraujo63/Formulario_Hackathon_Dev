<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\Chamada;
use App\Models\Aviso;
use App\Models\Mentor;
use Illuminate\Support\Facades\Auth;

class MentorDashboardController extends Controller
{
    public function index()
    {
        // 1. Totais Gerais
        $totalAlunos = Aluno::count();
        $totalMentores = Mentor::count();

        // 2. Chamada Ativa (GLOBAL)
        // Removi o filtro de ID. Agora mostra a última chamada ativa da escola inteira.
        // Adicionei with('mentor') para podermos mostrar quem está dando a aula se quiser.
        $chamadaAtiva = Chamada::where('ativa', true)
                               ->with('mentor')
                               ->latest()
                               ->first();

        // 3. Cálculo de Presença (MANTIVE PESSOAL)
        // As estatísticas de performance continuam sendo apenas do mentor logado,
        // para ele saber como está a frequência das SUAS aulas.
        $presencaMedia = 0;
        $ultimasChamadas = Chamada::where('mentor_id', Auth::guard('mentor')->id())
                                  ->withCount('presencas')
                                  ->latest()
                                  ->take(5)
                                  ->get();

        if($ultimasChamadas->count() > 0) {
            $totalPresencas = $ultimasChamadas->sum('presencas_count');
            // Evita divisão por zero
            $totalPossivel = ($totalAlunos * $ultimasChamadas->count()) ?: 1;

            $presencaMedia = round(($totalPresencas / $totalPossivel) * 100);

            // Trava visual em 100%
            if($presencaMedia > 100) $presencaMedia = 100;
        }

        // 4. Últimos Alunos Cadastrados
        $novosAlunos = Aluno::latest()->take(5)->get();

        // 5. Últimos Avisos do Mural
        $ultimosAvisos = Aviso::with('mentor')->latest()->take(3)->get();

        return view('mentor.dashboard', compact(
            'totalAlunos',
            'totalMentores',
            'chamadaAtiva',
            'presencaMedia',
            'novosAlunos',
            'ultimosAvisos'
        ));
    }
}
