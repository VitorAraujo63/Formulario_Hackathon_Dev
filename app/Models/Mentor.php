<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // IMPORTANTE
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Mentor extends Authenticatable
{
    use HasFactory, Notifiable;

    // Define a tabela explicitamente
    protected $table = 'mentores';

    protected $fillable = [
        'nome',
        'email',
        'password',
        'funcao',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'mentor_permissions');
    }
    

    // Função auxiliar para verificar se tem a permissão
    public function hasPermission($slug)
    {
        // Se for Admin Supremo, tem acesso a tudo sempre
        if ($this->funcao === 'Admin') {
            return true;
        }

        return $this->permissions->contains('slug', $slug);
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            // Caminho público direto para o SeaweedFS
            return "http://72.60.8.197:8888/buckets/mentoria/" . $this->foto;
        }
        return "https://ui-avatars.com/api/?name=" . urlencode($this->nome);
    }

    protected static function booted()
    {
        static::deleting(function ($mentor) {
            if ($mentor->foto) {
                // Remove o arquivo físico do SeaweedFS antes de deletar o registro
                Storage::disk('s3')->delete($mentor->foto);
            }
        });
    }
}
