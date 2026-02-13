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
        'cpf', 
        'telefone',
        'nascimento',
        'sexo',
        'estado',
        'cidade',
        'curso',
        'linkedin',
        'sobre',
        'nome_responsavel', 
        'telefone_responsavel',
        'selected_area',
        'user_answers',
        'score_total',
        'score_facil',
        'score_medio',
        'score_dificil',
        'calculated_level',
    ];

    protected $casts = [
        'user_answers' => 'array',
        'nascimento' => 'date',
    ];
}
