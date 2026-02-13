<?php

namespace App\Http\Controllers;

use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Http\Request;
use App\Models\Aluno;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Log;

class AlunoController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email_aluno' => ['required', 'email'],
            'password' => ['required']
        ]);

        $authData = [
            'email_aluno' => $credentials['email_aluno'],
            'password' => $credentials['password']
        ];

        if (Auth::guard('aluno')->attempt($authData)) {
            $request->session()->regenerate();
            return redirect()->intended(route('aluno.dashboard'));
        }

        return back()->withErrors(['email_aluno' => 'Dados incorretos.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('aluno')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function export()
    {
        $alunos = Aluno::all();
        return (new FastExcel($alunos))->download('lista_novos_alunos_2026.xlsx', function ($aluno) {
            return [
                'Nome Completo' => $aluno->nome_completo,
                'CPF' => $aluno->cpf,
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

        $cpfLimpo = preg_replace('/[^0-9]/', '', $request->cpf);

        if (Aluno::where('cpf', $cpfLimpo)->exists()) {
            return redirect()->back()->withErrors(['cpf' => 'Este CPF já está cadastrado como aluno.'])->withInput();
        }

        Aluno::create([
            'nome_completo' => $request->nome_completo,
            'data_nascimento' => $request->data_nascimento,
            'serie' => $request->serie,
            'escola' => $request->escola,
            'email_aluno' => $request->email_aluno,
            'cpf' => $cpfLimpo, 
            'telefone_aluno' => $request->telefone_aluno,
            'nome_responsavel' => $request->nome_responsavel,
            'email_responsavel' => $request->email_responsavel,
            'telefone_responsavel' => $request->telefone_responsavel,
            'tem_conhecimento_previo' => $request->tem_conhecimento == '1' ? true : false,
            'descricao_conhecimento' => $request->descricao_conhecimento,
            'onde_nos_conheceu' => $request->onde_conheceu,
            'password' => Hash::make('12345678'),
            'status' => 'ativo',
        ]);

        return redirect()->back()->with('success', true);
    }

    public function index()
    {
        $alunos = Aluno::orderBy('created_at', 'desc')->get();
        $totalAlunos = $alunos->count();
        $totalComConhecimento = $alunos->where('tem_conhecimento_previo', true)->count();
        $ultimoInscrito = $alunos->first() ? $alunos->first()->created_at->format('d/m/Y') : 'Ninguém';

        return view('mentor.alunos.index', compact('alunos', 'totalAlunos', 'totalComConhecimento', 'ultimoInscrito'));
    }

    public function destroy($id)
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->delete();
        return back()->with('success', 'Aluno removido com sucesso!');
    }

    public function downloadTemplate()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=modelo_importacao_alunos.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['nome_completo', 'cpf', 'data_nascimento', 'email_aluno', 'telefone_aluno', 'escola', 'serie', 'nome_responsavel', 'email_responsavel', 'telefone_responsavel'];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns, ';');
            fputcsv($file, [
                'Fulano da Silva', '00000000000', '2008-05-20', 'aluno@email.com', '11999998888',
                'Escola Estadual X', '3_em', 'Pai do Fulano', 'pai@email.com', '11988887777'
            ], ';');
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function import(Request $request)
    {
        $request->validate(['arquivo' => 'required|file|mimes:csv,txt']);
        $file = $request->file('arquivo');

        if (($handle = fopen($file->getPathname(), 'r')) !== false) {
            fgetcsv($handle, 1000, ';');
            while (($dados = fgetcsv($handle, 1000, ';')) !== false) {
                if (count($dados) < 5) continue;
                try {
                    Aluno::create([
                        'nome_completo'        => utf8_encode($dados[0]),
                        'cpf'                  => preg_replace('/[^0-9]/', '', $dados[1]),
                        'data_nascimento'      => $dados[2],
                        'email_aluno'          => $dados[3] ?: null,
                        'telefone_aluno'       => $dados[4],
                        'escola'               => utf8_encode($dados[5]),
                        'serie'                => $dados[6],
                        'nome_responsavel'     => utf8_encode($dados[7]),
                        'email_responsavel'    => $dados[8],
                        'telefone_responsavel' => $dados[9],
                        'password'             => Hash::make('12345678'),
                        'status'               => 'ativo',
                        'tem_conhecimento_previo' => false
                    ]);
                } catch (\Exception $e) {
                    continue;
                }
            }
            fclose($handle);
        }
        return back()->with('success', 'Importação concluída! Verifique a lista.');
    }

    public function update(Request $request, $id)
    {
        $aluno = Aluno::findOrFail($id);
        $dados = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'cpf' => 'required|string|max:14', 
            'data_nascimento' => 'required|date',
            'email_aluno' => 'nullable|email',
            'escola' => 'required|string',
            'serie' => 'required|string',
            'nome_responsavel' => 'required|string',
            'email_responsavel' => 'required|email',
            'telefone_responsavel' => 'required|string',
            'telefone_aluno' => 'nullable|string',
        ]);

        $dados['cpf'] = preg_replace('/[^0-9]/', '', $dados['cpf']);

        $aluno->update($dados);
        return back()->with('success', 'Dados do aluno atualizados com sucesso!');
    }   

    public function registerFromEcosystem(Request $request)
    {
        try {
            $formData = $request->input('formData');
            $cpf = preg_replace('/[^0-9]/', '', $formData['cpf'] ?? '');

            if (empty($cpf)) {
                return response()->json(['error' => 'CPF é obrigatório para o cadastro.'], 400);
            }

            $jaExiste = Aluno::where('cpf', $cpf)->exists();

            if ($jaExiste) {
                return response()->json([
                    'message' => 'Identificamos que você já possui um cadastro de aluno ativo em nossa base.'
                ], 422);
            }

            $novoAluno = Aluno::create([
                'nome_completo'         => $formData['nome'], 
                'email_aluno'           => $formData['email'],
                'cpf'                   => $cpf,
                'telefone_aluno'        => $formData['telefone'],
                'data_nascimento'       => $formData['nascimento'],
                'escola'                => $formData['cidade'], 
                'serie'                 => '3_em', // Valor padrão para conversão automática
                'nome_responsavel'      => $formData['nome_responsavel'] ?? 'Não informado',
                'email_responsavel'     => $formData['email_responsavel'] ?? ($formData['email'] . '.resp'), 
                'telefone_responsavel'  => $formData['telefone_responsavel'] ?? $formData['telefone'],
                'password'              => Hash::make('12345678'), 
                'status'                => 'ativo',
                'tem_conhecimento_previo' => false,
            ]);

            return response()->json([
                'message' => 'Parabéns! Sua matrícula no DevMenthors foi realizada com sucesso.',
                'aluno'   => $novoAluno
            ], 201);

        } catch (\Exception $e) {
            Log::error("Erro no cadastro automático via ecossistema: " . $e->getMessage());
            return response()->json([
                'error' => 'Erro interno ao processar cadastro.',
                'message' => 'Não foi possível completar sua matrícula automaticamente. Tente o formulário manual.'
            ], 500);
        }
    }
}