<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Mudar disto
use Illuminate\Notifications\Notifiable;

class Aluno extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'alunos';

    protected $fillable = [
        'nome_completo', 'data_nascimento', 'email_aluno', 'password',
        'telefone_aluno', 'escola', 'serie', 'nome_responsavel',
        'email_responsavel', 'telefone_responsavel', 'status',
        'tem_conhecimento_previo', 'descricao_conhecimento', 'onde_nos_conheceu'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'data_nascimento' => 'date',
        'tem_conhecimento_previo' => 'boolean',
    ];

    public function presencas()
    {
        return $this->belongsToMany(Chamada::class, 'presencas')
                    ->withPivot('registrado_em', 'manual')
                    ->withTimestamps();
    }
}
