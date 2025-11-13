<?php

namespace App\Http\Controllers\Api;

use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;

class FormSubmissionController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'formData.nome' => 'required|string|max:255',
            'formData.email' => 'required|email|max:255|unique:form_submissions,email',
            'formData.telefone' => 'required|string|max:20',
            'formData.nascimento' => 'required|date|before:today',
            'formData.sexo' => 'required|string|max:50',
            'formData.estado' => 'required|string|max:100',
            'formData.cidade' => 'required|string|max:100',
            'formData.curso' => 'required|string|max:255',
            'formData.linkedin' => 'nullable|string|url:http,https|max:255',
            'formData.sobre' => 'nullable|string|max:5000',
            'selectedArea' => 'required|string',
            'userAnswers' => 'required|array|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $formData = $request->input('formData');
        $selectedArea = $request->input('selectedArea');
        $userAnswers = $request->input('userAnswers');
        $correctAnswers = \Config::get('questions.' . $selectedArea);

        if (!$correctAnswers || count($correctAnswers) != 6) {
            return response()->json(['error' => 'Configuração do questionário inválida no servidor.'], 500);
        }

        $score_facil = 0;
        $score_media = 0;
        $score_dificil = 0;

        if ($userAnswers[0] == $correctAnswers[0]) $score_facil++;
        if ($userAnswers[1] == $correctAnswers[1]) $score_facil++;
        if ($userAnswers[2] == $correctAnswers[2]) $score_media++;
        if ($userAnswers[3] == $correctAnswers[3]) $score_media++;
        if ($userAnswers[4] == $correctAnswers[4]) $score_dificil++;
        if ($userAnswers[5] == $correctAnswers[5]) $score_dificil++;

        $score_total = $score_facil + $score_media + $score_dificil;

        $nivel = 'Iniciante';
        if ($score_total >= 3) {
            $nivel = 'Intermediário';
        }
        if ($score_total >= 5) {
            $nivel = 'Avançado';
        }

        try {
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
                'score_media' => $score_media,
                'score_dificil' => $score_dificil,
                'calculated_level' => $nivel,
            ]);

            // N8N Webhook
            Http::post('http://host.docker.internal:5678/webhook/hackathon-inscricao', [
                'telefone' => $formData['telefone'],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Não foi possível salvar a resposta',
                'details' => $e->getMessage()
            ], 400);
        }

        return response()->json(['message' => 'Respostas salvas com sucesso!'], 201);
    }
}
