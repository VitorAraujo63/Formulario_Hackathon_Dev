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
        'foto',
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
    
    /**
     * Verifica se o mentor é Admin.
     */
    public function isAdmin()
    {
        return $this->funcao === 'Admin';
    }

    /**
     * Verifica se tem uma permissão específica.
     * Admins sempre têm todas as permissões.
     */
    public function hasPermission($slug)
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->permissions->contains('slug', $slug);
    }

    /**
     * Retorna todas as permissões do mentor.
     * Para Admins, retorna TODAS as permissões disponíveis.
     */
    public function getAllPermissions()
    {
        if ($this->isAdmin()) {
            return Permission::all();
        }
        return $this->permissions;
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
