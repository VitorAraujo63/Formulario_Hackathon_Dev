<?php

use App\Http\Controllers\AulaController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DevMenthorsController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AlunoAvisoController;
use App\Http\Controllers\FormularioHackthon;
use App\Http\Controllers\HacktonMentores;
use App\Http\Controllers\MentorAuthController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\AvisoController;
use App\Http\Controllers\AdminMentorController;
use App\Http\Controllers\AlunoDashboardController;
use App\Http\Controllers\ChamadaController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MentorDashboardController;
use App\Models\FormSubmission;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| 1. ROTAS PÚBLICAS (Acesso livre)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/registrar', function () {
    return view('vagas');
});

// Página do HackHealth
Route::get('/hackhealth', [FormularioHackthon::class, 'index'])->name('hackathon');

// Lógica de Inscrição Geral (Vagas)
Route::get('/inscricao', function () {
    $limiteVagas = 300;
    $totalInscritos = FormSubmission::count();
    $vagasEsgotadas = $totalInscritos >= $limiteVagas;
    return view('inscricao', compact('vagasEsgotadas'));
})->name('inscricao');

// Cadastro de Novos Alunos (Público)
Route::get('/inscricao-aluno', [AlunoController::class, 'create'])->name('aluno.create');
Route::post('/inscricao-aluno', [AlunoController::class, 'store'])->name('aluno.store');

Route::post('/inscricao-aluno-automatica', [AlunoController::class, 'registerFromEcosystem'])->name('aluno.register_ecosystem');

// Cadastro de Mentores (Público - Se for self-service)
Route::get('hackathon/mentor/cadastrar', [HacktonMentores::class, 'create'])->name('hackathon.mentor.create');
Route::post('hackathon/mentor/cadastrar', [HacktonMentores::class, 'store'])->name('hackathon.mentor.store');

Route::get('/mentor/foto/{filename}', [FotoController::class, 'show'])->name('foto.perfil');
Route::get('imagens/aluno/{filename}', [FotoController::class, 'showAluno'])->name('aluno.foto.proxy');
Route::get('imagens/mentor/{filename}', [FotoController::class, 'show'])->name('mentor.foto.proxy');
/*
|--------------------------------------------------------------------------
| 2. AUTENTICAÇÃO (Login e Logout)
|--------------------------------------------------------------------------
*/

// Tela de Login Unificada (Aquela com abas Aluno/Mentor)
Route::get('/login', function () {
    return view('auth.login-unificado');
})->name('login.unificado');

// Processar Login de Mentor
Route::post('/login/mentor', [MentorAuthController::class, 'login'])
    ->name('mentor.login.post');

// Processar Login de Aluno
Route::post('/login/aluno', [AlunoController::class, 'login'])
    ->name('aluno.login.post');

// Rotas de Logout (Preferencialmente POST por segurança)
Route::post('admin/logout', [MentorAuthController::class, 'logout'])->name('mentor.logout');
Route::post('portal/logout', [AlunoController::class, 'logout'])->name('aluno.logout');


/*
|--------------------------------------------------------------------------
| 3. ÁREA DO MENTOR (Acesso Restrito: auth:mentor)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:mentor'])->prefix('admin')->group(function () {

    // Dashboard Principal do Mentor
    Route::get('/dashboard', [MentorDashboardController::class, 'index'])
        ->name('mentor.dashboard');

    Route::get('/perfil', [App\Http\Controllers\MentorPerfilController::class, 'index'])->name('mentor.perfil');
    Route::post('/perfil', [App\Http\Controllers\MentorPerfilController::class, 'update'])->name('mentor.perfil.update');


    // --- Gestão de Alunos ---
    Route::prefix('alunos')->group(function () {
        Route::get('/', [AlunoController::class, 'index'])->name('admin.alunos.index');
        Route::get('/export', [AlunoController::class, 'export'])->name('admin.alunos.export');
        Route::get('/template', [AlunoController::class, 'downloadTemplate'])->name('admin.alunos.template');
        Route::post('/import', [AlunoController::class, 'import'])->name('admin.alunos.import');
        Route::put('/{id}', [AlunoController::class, 'update'])->name('admin.alunos.update');
        Route::delete('/{id}', [AlunoController::class, 'destroy'])->name('admin.alunos.destroy');
    });

    // --- Mural de Avisos (AGORA FORA DE ALUNOS) ---
    Route::prefix('avisos')->middleware('can:manage_avisos')->group(function () {
        Route::get('/', [AvisoController::class, 'index'])->name('admin.avisos.index');
        Route::post('/', [AvisoController::class, 'store'])->name('admin.avisos.store');
        Route::put('/{id}', [AvisoController::class, 'update'])->name('admin.avisos.update');
        Route::delete('/{id}', [AvisoController::class, 'destroy'])->name('admin.avisos.destroy');
    });

    // --- Chamada / Presença (AGORA FORA DE ALUNOS) ---
    Route::prefix('chamada')->middleware('can:manage_chamada')->group(function () {
        Route::get('/', [ChamadaController::class, 'index'])->name('admin.chamada.index');
        Route::post('/nova', [ChamadaController::class, 'store'])->name('admin.chamada.store');
        Route::get('/painel/{id}', [ChamadaController::class, 'painel'])->name('admin.chamada.painel');
        Route::post('/encerrar/{id}', [ChamadaController::class, 'encerrar'])->name('admin.chamada.encerrar');
        Route::get('/export/{id}', [ChamadaController::class, 'exportChamada'])->name('admin.chamada.export');
        Route::get('/alunos/search', [ChamadaController::class, 'searchAlunos'])->name('admin.chamada.alunos.search');

        // Ajax / Manual
        Route::get('/qr/{id}', [ChamadaController::class, 'getQrCode'])->name('admin.chamada.getQr');
        Route::get('/lista/{id}', [ChamadaController::class, 'getPresencas'])->name('admin.chamada.getPresencas');
        Route::post('/manual/{id}', [ChamadaController::class, 'storeManual'])->name('admin.chamada.storeManual');
    });

    // --- Gestão de Mentores ---
    Route::prefix('mentores')->middleware('can:manage_mentores')->group(function () {
        Route::get('/', [AdminMentorController::class, 'index'])->name('admin.mentores.index');
        Route::post('/', [AdminMentorController::class, 'store'])->name('admin.mentores.store');
        Route::put('/{id}', [AdminMentorController::class, 'update'])->name('admin.mentores.update');
        Route::delete('/{id}', [AdminMentorController::class, 'destroy'])->name('admin.mentores.destroy');

        Route::put('/{id}/permissoes', [AdminMentorController::class, 'updatePermissions'])
        ->name('admin.mentores.permissions');
    });

    // --- Gestão do Hackathon ---
    Route::prefix('hackathon')->group(function () {
        Route::get('/inscricoes', [AdminDashboardController::class, 'index'])->name('admin.hackathon.inscricoes');
        Route::get('/inscricoes/export', [AdminDashboardController::class, 'export'])->name('admin.hackathon.export');
    });

    // --- Gestão de Conteúdo (Aulas) ---
    Route::prefix('aulas')->middleware('can:manage_aulas')->group(function () {
        Route::get('/', [AulaController::class, 'index'])->name('admin.aulas.index');
        Route::post('/', [AulaController::class, 'store'])->name('admin.aulas.store');
        Route::put('/{id}', [AulaController::class, 'update'])->name('admin.aulas.update');
        Route::delete('/{id}', [AulaController::class, 'destroy'])->name('admin.aulas.destroy');
    });
    Route::get('/metricas', function() { return view('mentor.metricas.index'); })->name('admin.metricas.index');


});


/*
|--------------------------------------------------------------------------
| 4. ÁREA DO ALUNO (Acesso Restrito: auth:aluno)
|--------------------------------------------------------------------------
*/
Route::prefix('aluno')->name('aluno.')->middleware('auth:aluno')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AlunoDashboardController::class, 'index'])->name('dashboard');

    // Materiais (Aulas)
    Route::get('/materiais', [AlunoDashboardController::class, 'materiais'])->name('materiais');
    
    Route::get('material/download/{path}', [MaterialController::class, 'download'])
        ->where('path', '.*')
        ->name('material.download');

    // Histórico de Presença
    Route::get('/frequencia', [AlunoDashboardController::class, 'frequencia'])->name('frequencia');

    // Perfil
    Route::get('/perfil', [AlunoDashboardController::class, 'perfil'])->name('perfil');
    Route::post('/perfil', [AlunoDashboardController::class, 'updatePerfil'])->name('perfil.update');

    // Mural de Avisos
    Route::get('/avisos', [AlunoAvisoController::class, 'index'])->name('avisos.index');
    Route::post('/avisos/{id}/like', [AlunoAvisoController::class, 'toggleLike'])->name('avisos.like');
});

    Route::middleware(['auth:aluno'])->get('/presenca/registrar/{chamada_id}', [ChamadaController::class, 'registrarPresenca'])
        ->name('aluno.presenca.registrar');

    // Rota do Ecossitema
    Route::get('/ecossistema', function () {
        return view('ecossistema');
    })->name('ecossistema');


Route::get('/descobrir-grupos', function () {
    $response = Http::withHeaders([
        'apikey' => env('WHATSAPP_INSTANCE_TOKEN')
    ])->get(env('WHATSAPP_API_URL') . "/group/fetchAllGroups/" . env('WHATSAPP_INSTANCE_NAME'));

    return $response->json();
});