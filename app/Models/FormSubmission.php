<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'nascimento',
        'sexo',
        'estado',
        'cidade',
        'curso',
        'linkedin',
        'sobre',
        'selected_area',
        'user_answers',     // Importante estar aqui
        'score_total',
        'score_facil',
        'score_medio',      // Importante: verificar se no banco é score_medio ou score_media
        'score_dificil',
        'calculated_level',
    ];

    // Transforma automaticamente o Array em JSON ao salvar e JSON em Array ao ler
    protected $casts = [
        'user_answers' => 'array',
        'nascimento' => 'date',
    ];
}
