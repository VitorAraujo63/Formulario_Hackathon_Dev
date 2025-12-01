<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FormularioHackthon extends Controller
{
    public function store(Request $request)
    {
        $limiteVagas = 300;

        // Verifica se já atingiu o limite ANTES de validar ou salvar qualquer coisa
        if (FormSubmission::count() >= $limiteVagas) {
            return redirect()
                ->route('home') // Redireciona para a home
                ->with('error', 'Infelizmente as vagas se esgotaram!');
        }

        // ... O resto do seu código de validação e criação de usuário continua aqui ...

        // User::create([...]);
    }

    public function index()
    {
        // 1. Configuração do limite
        $limiteVagas = 300;

        // 2. Contagem atual do banco de dados
        $totalInscritos = FormSubmission::count();

        // 3. Cálculo das vagas restantes (não deixa ficar negativo)
        $vagasRestantes = max(0, $limiteVagas - $totalInscritos);

        // 4. Retorna a view 'hackathon' enviando a variável necessária
        // O nome 'hackathon' aqui deve corresponder ao nome do arquivo: resources/views/hackathon.blade.php
        return view('hackathon', compact('vagasRestantes'));
    }
}
