<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chamada extends Model
{
    protected $table = 'chamadas';
    protected $fillable = ['mentor_id', 'titulo', 'codigo_acesso', 'ativa'];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'mentor_id');
    }

    public function presencas()
    {
        return $this->belongsToMany(Aluno::class, 'presencas')
                    ->withPivot('registrado_em', 'manual') // <--- ISSO É ESSENCIAL
                    ->withTimestamps();
    }
}
