<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevMenthorsController;
use App\Models\FormSubmission;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\FormularioHackthon;
use App\Http\Controllers\HacktonMentores;
use App\Http\Controllers\MentorAuthController;

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


Route::get('/admin/login', [MentorAuthController::class, 'showLoginForm'])
    ->name('mentor.login');

// Processar Login
Route::post('/admin/login', [MentorAuthController::class, 'login'])
    ->name('mentor.login.post');

// Sair (Logout)
Route::get('/admin/logout', [MentorAuthController::class, 'logout'])
    ->name('mentor.logout');


Route::middleware(['auth:mentor'])->prefix('admin')->group(function () {

    // Dashboard Principal
    // Carrega a view: resources/views/mentor/dashboard.blade.php
    Route::get('/', function () {
        return view('mentor.dashboard');
    })->name('mentor.dashboard');


    // --- Grupo de Gestão (Prefixo: /admin/mentores) ---
    Route::prefix('mentores')->group(function () {

        // 1. Gerenciamento de Mentores
        Route::get('/', [HacktonMentores::class, 'index'])
            ->name('hackathon.mentor.index'); // Lista HTML

        Route::get('/export', [HacktonMentores::class, 'export'])
            ->name('hackathon.mentor.export'); // Baixar Excel

        Route::post('/import', [HacktonMentores::class, 'import'])
            ->name('hackathon.mentor.import'); // Upload Excel


        // 2. Gerenciamento de Inscrições (Quiz dos Candidatos)
        Route::get('/inscricoes', [AdminDashboardController::class, 'index'])
            ->name('hackathon.mentor.inscricoes'); // Lista HTML

        Route::get('/inscricoes/export', [AdminDashboardController::class, 'export'])
            ->name('hackathon.inscricoes.export'); // Baixar Excel
    });

});
