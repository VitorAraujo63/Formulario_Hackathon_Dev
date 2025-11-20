<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class FormSubmissionController extends Controller
{
    public function store(Request $request)
    {
        // 1. BLOQUEIO DE SEGURANÇA
        if (FormSubmission::count() >= 300) {
            return response()->json(['error' => 'Inscrições encerradas. Limite de vagas atingido.'], 403);
        }

        // 2. VALIDAÇÃO
        $validator = Validator::make($request->all(), [
            'formData.nome' => 'required|string|max:255',

            // ALTERAÇÃO AQUI: Adicionado |unique:form_submissions,email
            // Isso impede o erro 500 e retorna um erro amigável para o front-end
            'formData.email' => 'required|email|max:255|unique:form_submissions,email',

            'formData.telefone' => 'required|string|max:20',
            'formData.nascimento' => 'required|date',
            'formData.sexo' => 'required|string',
            'formData.estado' => 'required|string',
            'formData.cidade' => 'required|string',
            'formData.curso' => 'required|string',
            'formData.linkedin' => 'nullable|string',
            'formData.sobre' => 'nullable|string',
            'selectedArea' => 'required|string',
            'userAnswers' => 'required|array|size:6',
        ], [
            // Mensagens personalizadas (Opcional)
            'formData.email.unique' => 'Este e-mail já realizou a inscrição.'
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
                Log::error("Gabarito ausente em config/questions.php para: " . $selectedArea);
                throw new \Exception("Erro de configuração: Área não encontrada no gabarito.");
            }

            $score_facil = 0;
            $score_medio_calc = 0;
            $score_dificil = 0;

            for ($i = 0; $i < 6; $i++) {
                if (isset($userAnswers[$i]) && isset($correctAnswers[$i]) && $userAnswers[$i] == $correctAnswers[$i]) {
                    if ($i < 2) $score_facil++;
                    elseif ($i < 4) $score_medio_calc++;
                    else $score_dificil++;
                }
            }

            $score_total = $score_facil + $score_medio_calc + $score_dificil;

            $nivel = 'Iniciante';
            if ($score_total >= 3) $nivel = 'Intermediário';
            if ($score_total >= 5) $nivel = 'Avançado';

            $submission = FormSubmission::create([
                'nome' => $formData['nome'],
                'email' => $formData['email'],
                'telefone' => $formData['telefone'] ?? null,
                'nascimento' => $formData['nascimento'] ?? null,
                'sexo' => $formData['sexo'] ?? null,
                'estado' => $formData['estado'] ?? null,
                'cidade' => $formData['cidade'] ?? null,
                'curso' => $formData['curso'] ?? null,
                'linkedin' => $formData['linkedin'] ?? null,
                'sobre' => $formData['sobre'] ?? null,
                'selected_area' => $selectedArea,
                'user_answers' => $userAnswers,
                'score_total' => $score_total,
                'score_facil' => $score_facil,
                'score_medio' => $score_medio_calc,
                'score_dificil' => $score_dificil,
                'calculated_level' => $nivel,
            ]);

            return response()->json(['message' => 'Sucesso!', 'id' => $submission->id], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro interno no servidor',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
}
