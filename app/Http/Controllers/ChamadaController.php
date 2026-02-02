<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Chamada;
use App\Models\Aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChamadaController extends Controller
{
    // --- 1. LISTAGEM GERAL (Todas as salas da escola) ---
    public function index()
    {
        $chamadas = Chamada::with('mentor') // Carrega o dono da chamada
                            ->withCount('presencas')
                            ->latest()
                            ->get();

        return view('mentor.chamada.index', compact('chamadas'));
    }

    // --- 2. CRIAR/REABRIR CHAMADA (Resolve o erro de Duplicidade) ---
    public function store(Request $request)
    {
        $request->validate([
            'sala' => 'required|string|max:50',
        ]);

        // A. Verifica se JÁ EXISTE UMA AULA ATIVA nesta sala agora
        $chamadaAtiva = Chamada::where('codigo_acesso', $request->sala)
                               ->where('ativa', true)
                               ->first();

        if ($chamadaAtiva) {
            return redirect()->route('admin.chamada.painel', $chamadaAtiva->id)
                             ->with('warning', 'Esta sala já possui uma chamada em andamento.');
        }

        // B. Cria uma NOVA chamada (O banco agora permite nomes repetidos no histórico)
        $chamada = Chamada::create([
            'mentor_id' => Auth::guard('mentor')->id(),
            'titulo' => $request->titulo ?? 'Aula do dia ' . date('d/m'),
            'codigo_acesso' => $request->sala,
            'current_token' => Str::random(10),
            'ativa' => true
        ]);

        return redirect()->route('admin.chamada.painel', $chamada->id);
    }

    // --- 3. PAINEL DA CHAMADA ---
    public function painel($id)
    {
        $chamada = Chamada::findOrFail($id);
        return view('mentor.chamada.painel', compact('chamada'));
    }

    // --- 4. API: GERAR QR CODE ---
    public function getQrCode($id)
    {
        $chamada = Chamada::findOrFail($id);

        if (!$chamada->ativa) {
            return response()->json(['error' => 'Chamada encerrada'], 403);
        }

        // Rotaciona token
        $novoToken = Str::random(10);
        $chamada->previous_token = $chamada->current_token;
        $chamada->current_token = $novoToken;
        $chamada->save();

        return response()->json(['qr_code' => $novoToken]);
    }

    // --- 5. API: LISTA DE PRESENÇA (JSON) ---
    public function getPresencas($id)
    {
        $chamada = Chamada::findOrFail($id);

        $presencas = $chamada->presencas()
                             ->withPivot('registrado_em', 'manual')
                             ->get()
                             ->sortByDesc(function($p) {
                                 return $p->pivot->registrado_em ?? $p->pivot->created_at;
                             });

        $listaFormatada = $presencas->map(function($aluno) {
            $data = $aluno->pivot->registrado_em ?? now();
            return [
                'id' => $aluno->id,
                'nome' => $aluno->nome_completo,
                'avatar' => strtoupper(substr($aluno->nome_completo, 0, 2)),
                'horario' => date('H:i', strtotime($data))
            ];
        })->values();

        return response()->json([
            'total' => $presencas->count(),
            'alunos' => $listaFormatada
        ]);
    }

    // --- 6. API: BUSCA MANUAL DE ALUNOS ---
    public function searchAlunos(Request $request)
    {
        $term = $request->query('q');
        if (!$term) return response()->json([]);

        $alunos = Aluno::where('nome_completo', 'LIKE', "%{$term}%")
                        ->orWhere('email_aluno', 'LIKE', "%{$term}%")
                        ->limit(5)
                        ->get(['id', 'nome_completo', 'serie']);

        return response()->json($alunos);
    }

    // --- 7. API: SALVAR PRESENÇA MANUAL ---
    public function storeManual(Request $request, $id)
    {
        $chamada = Chamada::findOrFail($id);
        $alunoId = $request->aluno_id;

        if (!$alunoId) return response()->json(['error' => 'Aluno inválido'], 400);

        if(!$chamada->presencas()->where('aluno_id', $alunoId)->exists()) {
             $chamada->presencas()->attach($alunoId, [
                'registrado_em' => now(),
                'manual' => true
            ]);
            return response()->json(['success' => true, 'message' => 'Presença registrada!']);
        }

        return response()->json(['message' => 'Aluno já estava na lista.'], 200);
    }

    // --- 8. AÇÃO: ENCERRAR CHAMADA ---
    public function encerrar($id)
    {
        $chamada = Chamada::findOrFail($id);
        $chamada->update(['ativa' => false]);
        return redirect()->route('admin.chamada.index');
    }

    // --- 9. AÇÃO: EXPORTAR CSV (A FUNÇÃO QUE FALTAVA) ---
    public function exportChamada($id)
    {
        $chamada = Chamada::with('presencas')->findOrFail($id);

        $fileName = 'lista_' . Str::slug($chamada->codigo_acesso) . '_' . date('d-m-Y') . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Nome do Aluno', 'Serie', 'Horario Chegada', 'Tipo Registro'];

        $callback = function() use ($chamada, $columns) {
            $file = fopen('php://output', 'w');
            // Adiciona BOM para o Excel abrir acentos corretamente
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns, ';'); // Separador ; para Excel BR

            foreach ($chamada->presencas as $aluno) {
                $data = $aluno->pivot->registrado_em ?? $aluno->pivot->created_at;

                fputcsv($file, [
                    $aluno->nome_completo,
                    $aluno->serie,
                    date('H:i:s', strtotime($data)),
                    $aluno->pivot->manual ? 'MANUAL' : 'QR CODE'
                ], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // --- 10. LÓGICA DO ALUNO (LINK DO QR CODE) ---
    public function registrarPresenca(Request $request, $chamada_id)
    {
        $chamada = Chamada::findOrFail($chamada_id);
        $aluno = Auth::guard('aluno')->user();

        // View de ERRO atualizada
        if (!$chamada->ativa) return view('aluno.resposta.erro', ['msg' => 'Chamada encerrada.']);

        $tokenLink = $request->query('token');

        // View de ERRO atualizada
        if ($tokenLink !== $chamada->current_token && $tokenLink !== $chamada->previous_token) {
            return view('aluno.resposta.erro', ['msg' => 'QR Code expirado.']);
        }

        if (!$chamada->presencas()->where('aluno_id', $aluno->id)->exists()) {
             $chamada->presencas()->attach($aluno->id, [
                'registrado_em' => now(),
                'manual' => false
            ]);
        }

        // View de SUCESSO atualizada
        return view('aluno.resposta.sucesso', ['msg' => 'Presença Confirmada!']);
    }
}
