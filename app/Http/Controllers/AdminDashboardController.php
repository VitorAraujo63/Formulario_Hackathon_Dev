<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $submissions = FormSubmission::orderBy('created_at', 'desc')->get();

        return view('admin-dashboard-excel', [
            'submissions' => $submissions
        ]);
    }

    /**
     * Exportação Otimizada de Excel
     */
    public function export()
    {
        // SOLUÇÃO DO ERRO:
        // Criamos uma função anônima que itera sobre o cursor e faz o 'yield'.
        // Isso converte a LazyCollection do Laravel em um Generator nativo do PHP.
        $submissionsGenerator = function () {
            foreach (FormSubmission::orderBy('created_at', 'desc')->cursor() as $submission) {
                yield $submission;
            }
        };

        // Agora passamos a execução da função ($submissionsGenerator()) que retorna o Generator
        return (new FastExcel($submissionsGenerator()))->download('resultados_hackathon_niveis.xlsx', function ($sub) {
            return [
                'ID' => $sub->id,
                'Nome' => $sub->nome,
                'Email' => $sub->email,
                'Telefone' => $sub->telefone,
                'Área de Interesse' => $sub->selected_area,
                'Acertos (Total)' => $sub->score_total,
                'Acertos (Fácil)' => $sub->score_facil,
                'Acertos (Médio)' => $sub->score_medio,
                'Acertos (Difícil)' => $sub->score_dificil,
                'Nível Calculado' => $sub->calculated_level,
                'Data de Envio' => $sub->created_at->format('d/m/Y H:i'),
            ];
        });
    }
}
