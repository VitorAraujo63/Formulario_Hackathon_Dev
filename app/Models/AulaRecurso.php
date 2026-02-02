<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AulaRecurso extends Model
{
    protected $fillable = ['aula_id', 'titulo', 'tipo', 'path', 'extensao'];

    public function aula() { return $this->belongsTo(Aula::class); }

    public function getUrlAttribute()
    {
        if ($this->tipo === 'link') return $this->path;

        // URL direta do seu SeaweedFS Público
        return "http://72.60.8.197:8888/buckets/mentoria/" . $this->path;
    }
}
