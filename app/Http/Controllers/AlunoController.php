<?php

namespace App\Http\Controllers;

use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Http\Request;
use App\Models\Aluno;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // IMPORTANTE: Necessário para o Login
use Illuminate\Support\Facades\Hash; // IMPORTANTE: Necessário para a Senha

class AlunoController extends Controller
{
    // ==========================================
    // NOVAS FUNÇÕES DE LOGIN/LOGOUT (ADICIONADAS)
    // ==========================================

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email_aluno' => ['required', 'email'], // Note que no seu Model é email_aluno
            'password' => ['required'],
        ]);

        // Mapear 'email_aluno' para 'email' ou passar array customizado se o attempt exigir 'email'
        // O Auth::attempt espera chaves que batem com o banco, exceto password que ele trata.
        // Como sua coluna chama 'email_aluno', precisamos passar assim:
        $authData = [
            'email_aluno' => $credentials['email_aluno'],
            'password' => $credentials['password']
        ];

        // Usa o GUARD 'aluno'
        if (Auth::guard('aluno')->attempt($authData)) {
            $request->session()->regenerate();

            // Redireciona para Dashboard do ALUNO
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

    // ==========================================
    // FUNÇÕES EXISTENTES (MANTIDAS/ATUALIZADAS)
    // ==========================================

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
        // ATENÇÃO: Adicionei campos 'password' e 'status' para que o aluno consiga logar depois
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

            // Novos campos obrigatórios para login:
            'password' => Hash::make('12345678'), // Senha padrão (você pode mudar lógica depois)
            'status' => 'ativo',

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

        // Pequena correção para evitar erro se não tiver alunos
        $ultimoInscrito = $alunos->first() ? $alunos->first()->created_at->format('d/m/Y') : 'Ninguém';

        return view('mentor.alunos.index', compact('alunos', 'totalAlunos', 'totalComConhecimento', 'ultimoInscrito'));
    }

    public function destroy($id)
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->delete();
        return back()->with('success', 'Aluno removido com sucesso!');
    }

    // Método para baixar o modelo (Template)
    public function downloadTemplate()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=modelo_importacao_alunos.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'nome_completo',
            'data_nascimento (AAAA-MM-DD)',
            'email_aluno',
            'telefone_aluno',
            'escola',
            'serie (Ex: 9_ano, 3_em)',
            'nome_responsavel',
            'email_responsavel',
            'telefone_responsavel'
        ];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');

            // Adiciona o BOM para o Excel abrir corretamente com acentos (UTF-8)
            fputs($file, "\xEF\xBB\xBF");

            // Escreve o cabeçalho
            fputcsv($file, $columns, ';');

            // Escreve uma linha de exemplo para o usuário entender o formato
            fputcsv($file, [
                'Fulano da Silva',
                '2008-05-20',
                'aluno@email.com',
                '11999998888',
                'Escola Estadual X',
                '3_em',
                'Pai do Fulano',
                'pai@email.com',
                '11988887777'
            ], ';');

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Método para importar
    public function import(Request $request)
    {
        $request->validate([
            'arquivo' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('arquivo');

        // Abre o arquivo em modo de leitura
        if (($handle = fopen($file->getPathname(), 'r')) !== false) {

            // 1. Pula a primeira linha (Cabeçalho)
            fgetcsv($handle, 1000, ';');

            // 2. Loop para ler linha por linha
            // O parâmetro ';' define que o separador é ponto e vírgula
            while (($dados = fgetcsv($handle, 1000, ';')) !== false) {

                // Validação simples para evitar linhas em branco
                if (count($dados) < 5) continue;

                // Mapeamento das colunas (baseado na ordem do Template)
                // 0: Nome, 1: Data, 2: Email Aluno, 3: Tel Aluno, 4: Escola, 5: Série,
                // 6: Nome Resp, 7: Email Resp, 8: Tel Resp

                try {
                    \App\Models\Aluno::create([
                        'nome_completo'        => utf8_encode($dados[0]), // utf8_encode previne erros de acentuação
                        'data_nascimento'      => $dados[1],
                        'email_aluno'          => $dados[2] ?: null, // Se vazio, salva null
                        'telefone_aluno'       => $dados[3],
                        'escola'               => utf8_encode($dados[4]),
                        'serie'                => $dados[5],
                        'nome_responsavel'     => utf8_encode($dados[6]),
                        'email_responsavel'    => $dados[7], // Campo obrigatório que estava dando erro antes
                        'telefone_responsavel' => $dados[8],
                        'password'             => '$2y$12$H/vNUWMtKJy5rUliqy8vHeZ8avg0nsNahitXJSNJ49W1swzhu5qMm', // Senha padrão (hash)
                        'status'               => 'ativo',
                        'tem_conhecimento_previo' => false // Padrão
                    ]);
                } catch (\Exception $e) {
                    // Se der erro em uma linha específica (ex: email duplicado),
                    // continuamos para a próxima sem quebrar tudo.
                    // Você pode logar o erro se quiser: Log::error($e->getMessage());
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
            'data_nascimento' => 'required|date',
            'email_aluno' => 'nullable|email',
            'escola' => 'required|string',
            'serie' => 'required|string',
            'nome_responsavel' => 'required|string',
            'email_responsavel' => 'required|email',
            'telefone_responsavel' => 'required|string',
            'telefone_aluno' => 'nullable|string',
        ]);

        $aluno->update($dados);

        return back()->with('success', 'Dados do aluno atualizados com sucesso!');
    }
}
