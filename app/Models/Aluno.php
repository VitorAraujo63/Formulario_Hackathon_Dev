<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    protected $table = 'alunos';

    protected $fillable = [
        'nome_completo', 'data_nascimento', 'email_aluno', 'telefone_aluno',
        'escola', 'serie', 'nome_responsavel', 'email_responsavel',
        'telefone_responsavel', 'tem_conhecimento_previo', 
        'descricao_conhecimento', 'onde_nos_conheceu'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'tem_conhecimento_previo' => 'boolean',
    ];
}