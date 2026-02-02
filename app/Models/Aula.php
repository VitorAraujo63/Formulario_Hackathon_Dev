<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; // <--- Não esqueça de importar isso

class Aula extends Model
{
    protected $fillable = ['aula_categoria_id', 'titulo', 'descricao', 'data_prevista', 'publicada'];

    // Relacionamentos
    public function categoria()
    {
        return $this->belongsTo(AulaCategoria::class, 'aula_categoria_id');
    }

    public function recursos()
    {
        return $this->hasMany(AulaRecurso::class);
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    // --- A MÁGICA DA LIMPEZA ACONTECE AQUI ---
    protected static function booted()
    {
        static::deleting(function ($aula) {
            // 1. Apaga a pasta física no SeaweedFS (ex: aulas/15/)
            // Isso remove todos os arquivos dessa aula de uma vez.
            if (Storage::disk('s3')->exists("aulas/{$aula->id}")) {
                Storage::disk('s3')->deleteDirectory("aulas/{$aula->id}");
            }

            // 2. Opcional: Se houver arquivos soltos que não estavam na pasta (legado),
            // varre os recursos e deleta um por um.
            foreach ($aula->recursos as $recurso) {
                if ($recurso->tipo === 'arquivo' && Storage::disk('s3')->exists($recurso->path)) {
                    Storage::disk('s3')->delete($recurso->path);
                }
            }
        });
    }
}
