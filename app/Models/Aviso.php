<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aviso extends Model
{
    protected $table = 'avisos';

    protected $fillable = [
        'titulo',
        'conteudo',
        'imagem',        // Novo
        'fixado',        // Novo
        'visivel_todos', // Já existia na sua migration
        'mentor_id'
    ];

    protected $casts = [
        'fixado' => 'boolean',
        'visivel_todos' => 'boolean'
    ];

    // Relacionamento com quem postou
    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'mentor_id');
    }

    // Relacionamento de quem curtiu (Muitos Alunos)
    public function curtidas()
    {
        return $this->belongsToMany(Aluno::class, 'aviso_likes', 'aviso_id', 'aluno_id')
                    ->withPivot('created_at');
    }
}
