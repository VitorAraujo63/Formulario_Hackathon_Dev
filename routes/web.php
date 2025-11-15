<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevMenthorsController;
use App\Models\FormSubmission;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Controllers\AdminDashboardController;

Route::get('/admin/dashboard/excel', [AdminDashboardController::class, 'index']);

// Rota para exportação
Route::get('/admin/export', function () {
    $submissions = FormSubmission::select(
        'nome',
        'email',
        'telefone',
        'selected_area',
        'score_total',
        'score_facil',
        'score_dificil',
        'calculated_level',
        'created_at'
    )->get();

    // Renomeando colunas para o excel
    $list_to_export = $submissions->map(function ($item){
        return [
            'Nome' => $item->nome,
            'Email' => $item->email,
            'Telefone' => $item->telefone,
            'Área de interesse' => $item->selected_area,
            'Acertos (Total)' => $item->score_total,
            'Acertos (Fácil)' => $item->score_facil,
            'Acertos (Médio)' => $item->score_medio,
            'Acertos (Difícil)' => $item->score_dificil,
            'Nível Calculado' => $item->calculated_level,
            'Data de envio' => $item->created_at->format('d/m/Y H:i'),
        ];
    });

    return (new FastExcel($list_to_export))->download('resultados_hackathon_niveis.xlsx');
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/hackathon', function () {
    return view('hackathon');
});

Route::get('/inscricao', function () {
    return view('inscricao');
})->name('inscricao');