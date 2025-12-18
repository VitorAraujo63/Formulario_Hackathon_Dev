<?php

namespace App\Http\Controllers;

use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Http\Request;
use App\Models\Aluno; 
use Illuminate\Support\Facades\DB;

class AlunoController extends Controller
{
    public function export()
    {
        $alunos = Aluno::all();
        return (new FastExcel($alunos))->download('lista_novos_alunos_2026.xlsx', function ($aluno) {
            return [
                'Nome Completo' => $aluno->nome_completo,
                'Série' => str_replace(['_ano', '_em'], ['º Ano', 'ª Série'], $aluno->serie),
                'Telefone Aluno' => $aluno->telefone_aluno,
                'Telefone Responsável' => $aluno->telefone_responsavel,
                'Instituição' => $aluno->escola,
            ];
        });
    }
    public function create()
    {
        return view('formulario_novos_alunos.cadastro');
    }

    public function store(Request $request)
    {
        DB::table('alunos')->insert([
            'nome_completo' => $request->nome_completo,
            'data_nascimento' => $request->data_nascimento,
            'serie' => $request->serie,
            'escola' => $request->escola,
            'email_aluno' => $request->email_aluno,
            'telefone_aluno' => $request->telefone_aluno,
            'nome_responsavel' => $request->nome_responsavel,
            'email_responsavel' => $request->email_responsavel,
            'telefone_responsavel' => $request->telefone_responsavel,
            'tem_conhecimento_previo' => $request->tem_conhecimento == '1' ? true : false,
            'descricao_conhecimento' => $request->descricao_conhecimento,
            'onde_nos_conheceu' => $request->onde_conheceu,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', true);
    }

    public function index()
    {
        $alunos = Aluno::orderBy('created_at', 'desc')->get();
        $totalAlunos = $alunos->count();
        $totalComConhecimento = $alunos->where('tem_conhecimento_previo', true)->count();
        $ultimoInscrito = $alunos->first() ? $alunos->first()->created_at->format('d/m/Y') : 'Ninguém';

        return view('formulario_novos_alunos.dashboard', compact('alunos', 'totalAlunos', 'totalComConhecimento', 'ultimoInscrito'));
    }
}