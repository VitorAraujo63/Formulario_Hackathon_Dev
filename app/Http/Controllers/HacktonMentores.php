<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMentorRequest;
use Illuminate\Http\Request;
// 1. Importe o Controller base do Laravel
use Illuminate\Routing\Controller;

// 2. DÊ UM APELIDO para o seu Model para evitar conflito
use App\Models\HacktonMentores as MentorModel;
use Rap2hpoutre\FastExcel\FastExcel;

// 3. Sua classe DEVE extender 'Controller'
class HacktonMentores extends Controller
{
    public function index()
    {
        $mentores = MentorModel::latest()->get();
        return view('gestao_mentores_hackhealth', compact('mentores'));
    }

    /**
     * Exporta os mentores para Excel
     */
    public function export()
    {
        $mentores = MentorModel::all();

        return (new FastExcel($mentores))->download('lista_mentores_hackathon.xlsx', function ($mentor) {

            // Formata o array de disponibilidade para texto (ex: "Manhã, Tarde")
            $disp = is_array($mentor->disponibilidade)
                ? implode(', ', $mentor->disponibilidade)
                : $mentor->disponibilidade;

            return [
                'ID' => $mentor->id,
                'Nome' => $mentor->nome,
                'RG' => $mentor->rg,
                'Instituição' => $mentor->instituicao,
                'Especialidade' => $mentor->especialidade,
                'Disponibilidade' => $disp,
                'Data Cadastro' => $mentor->created_at->format('d/m/Y H:i'),
            ];
        });
    }

    /**
     * Importa mentores via Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'arquivo_excel' => 'required|mimes:xlsx,xls'
        ]);

        try {
            $path = $request->file('arquivo_excel');

            (new FastExcel)->import($path, function ($line) {
                // Lógica para tratar a disponibilidade que vem como string do Excel
                // Exemplo esperado no Excel: "29_manha, 29_tarde"
                $disponibilidadeArray = [];
                if (isset($line['Disponibilidade'])) {
                    $disponibilidadeArray = array_map('trim', explode(',', $line['Disponibilidade']));
                }

                return MentorModel::create([
                    'nome' => $line['Nome'],
                    'rg' => $line['RG'] ?? null,
                    'instituicao' => $line['Instituição'] ?? null,
                    'especialidade' => $line['Especialidade'] ?? null,
                    'disponibilidade' => $disponibilidadeArray,
                ]);
            });

            return redirect()->route('hackathon.mentor.index')->with('success', 'Importação realizada com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['msg' => 'Erro na importação: ' . $e->getMessage()]);
        }
    }

    /**
     * Mostra o formulário de cadastro.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Salva o novo mentor no banco de dados.
     */
    public function store(StoreMentorRequest $request)
    {
        try {
            // 4. Use o APELIDO (MentorModel) para chamar o Model
            MentorModel::create($request->validated());

            return redirect()->route('hackathon.mentor.store')
                         ->with('success', 'Mentor cadastrado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                         ->withErrors(['msg' => 'Erro ao salvar no banco de dados: ' . $e->getMessage()])
                         ->withInput();
        }
    }
}
