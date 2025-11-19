<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevMenthorsController;
use App\Models\FormSubmission;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\FormularioHackthon;
use App\Http\Controllers\HacktonMentores;

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
})->name('home');

Route::get('/registrar', function () {
    return view('vagas');
});

Route::get('/hackhealth', [FormularioHackthon::class, 'index'])->name('hackathon');


Route::get('/inscricao', function () {

    $limiteVagas = 300;


    $totalInscritos = FormSubmission::count();


    $vagasEsgotadas = $totalInscritos >= $limiteVagas;


    return view('inscricao', compact('vagasEsgotadas'));
})->name('inscricao');

Route::get('hackathon/mentor/cadastrar', [HacktonMentores::class, 'create'])->name('hackathon.mentor.create');

Route::post('hackathon/mentor/cadastrar', [HacktonMentores::class, 'store'])->name('hackathon.mentor.store');

Route::prefix('admin/mentores')->group(function () {

    // Painel de Gestão (Chama o seu arquivo gestao_mentores_hackhealth.blade.php)
    Route::get('/', [HacktonMentores::class, 'index'])
        ->name('hackathon.mentor.index');

    // Download do Excel
    Route::get('/export', [HacktonMentores::class, 'export'])
        ->name('hackathon.mentor.export');

    // Upload do Excel
    Route::post('/import', [HacktonMentores::class, 'import'])
        ->name('hackathon.mentor.import');
});
