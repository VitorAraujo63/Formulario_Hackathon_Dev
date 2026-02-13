<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http; 
use Carbon\Carbon;

class FormSubmissionController extends Controller
{
    public function store(Request $request)
    {
        if ($request->has('formData.cpf')) {
            $cpfLimpo = preg_replace('/[^0-9]/', '', $request->input('formData.cpf'));
            $request->merge([
                'formData' => array_merge($request->input('formData'), ['cpf' => $cpfLimpo])
            ]);
        }

        if (FormSubmission::count() >= 300) {
            return response()->json(['error' => 'Inscrições encerradas. Limite de vagas atingido.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'formData.nome' => 'required|string|max:255',
            'formData.email' => 'required|email|max:255|unique:form_submissions,email', 
            'formData.cpf' => 'required|string|size:11|unique:form_submissions,cpf',
            'formData.telefone' => 'required|string|max:20',
            'formData.nascimento' => 'required|date',
            'formData.sexo' => 'required|string',
            'formData.estado' => 'required|string',
            'formData.cidade' => 'required|string',
            'formData.curso' => 'nullable|string', 
            
            'formData.linkedin' => 'nullable|string',
            'formData.sobre' => 'nullable|string',
            'formData.nome_responsavel' => 'nullable|string|max:255',
            'formData.telefone_responsavel' => 'nullable|string|max:20',
            'selectedArea' => 'required|string',
            'userAnswers' => 'required|array|size:6',
        ], [
            'formData.email.unique' => 'Este e-mail já realizou a inscrição para este Hackathon.',
            'formData.cpf.unique' => 'Este CPF já realizou a inscrição para este Hackathon.',
            'formData.cpf.size' => 'O CPF deve conter exatamente 11 números.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $formData = $request->input('formData');
            $selectedArea = $request->input('selectedArea');
            $userAnswers = $request->input('userAnswers');

            $correctAnswers = Config::get('questions.' . $selectedArea);
            if (!$correctAnswers) {
                Log::error("Gabarito ausente para: " . $selectedArea);
                throw new \Exception("Erro de configuração: Área não encontrada.");
            }

            $score_facil = 0; $score_medio_calc = 0; $score_dificil = 0;
            for ($i = 0; $i < 6; $i++) {
                if (isset($userAnswers[$i]) && isset($correctAnswers[$i]) && $userAnswers[$i] == $correctAnswers[$i]) {
                    if ($i < 2) $score_facil++;
                    elseif ($i < 4) $score_medio_calc++;
                    else $score_dificil++;
                }
            }

            $score_total = $score_facil + $score_medio_calc + $score_dificil;
            $nivel = ($score_total >= 5) ? 'Avançado' : (($score_total >= 3) ? 'Intermediário' : 'Iniciante');
            
            $submission = FormSubmission::create([
                'nome' => $formData['nome'],
                'email' => $formData['email'],
                'cpf' => $formData['cpf'], 
                'telefone' => $formData['telefone'] ?? null,
                'nascimento' => $formData['nascimento'] ?? null,
                'sexo' => $formData['sexo'] ?? null,
                'estado' => $formData['estado'] ?? null,
                'cidade' => $formData['cidade'] ?? null,
                'curso' => $formData['curso'] ?? null,
                'linkedin' => $formData['linkedin'] ?? null,
                'sobre' => $formData['sobre'] ?? null,
                'nome_responsavel' => $formData['nome_responsavel'] ?? null,
                'telefone_responsavel' => $formData['telefone_responsavel'] ?? null,

                'selected_area' => $selectedArea,
                'user_answers' => $userAnswers,
                'score_total' => $score_total,
                'score_facil' => $score_facil,
                'score_medio' => $score_medio_calc,
                'score_dificil' => $score_dificil,
                'calculated_level' => $nivel,
            ]);

            // --- LÓGICA DE WHATSAPP ---
            try {
                $nascimento = Carbon::parse($formData['nascimento']);
                $eMenor = $nascimento->age < 18;
                $telParticipante = preg_replace('/\D/', '', $formData['telefone']);
                $telResponsavel = isset($formData['telefone_responsavel']) ? preg_replace('/\D/', '', $formData['telefone_responsavel']) : null;

                $this->adicionarAoWhatsapp($telParticipante, env('WHATSAPP_GROUP_PARTICIPANTES'));

                if ($eMenor && $telResponsavel) {
                    $this->adicionarAoWhatsapp($telResponsavel, env('WHATSAPP_GROUP_RESPONSAVEIS'));
                }
            } catch (\Exception $waError) {
                Log::error("Falha na automação de WhatsApp: " . $waError->getMessage());
            }

            return response()->json(['message' => 'Sucesso!', 'id' => $submission->id], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro interno no servidor',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function adicionarAoWhatsapp($numero, $groupId)
    {
        if (!$numero || !$groupId) return;
        Http::withHeaders([
            'apikey' => env('WHATSAPP_INSTANCE_TOKEN')
        ])->post(env('WHATSAPP_API_URL') . "/group/updateParticipant/" . env('WHATSAPP_INSTANCE_NAME'), [
            'groupId' => $groupId,
            'action' => 'add',
            'participants' => [$numero . "@s.whatsapp.net"]
        ]);
    }
}