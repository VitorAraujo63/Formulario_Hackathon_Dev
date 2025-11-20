<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // IMPORTANTE
use Illuminate\Notifications\Notifiable;

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
}
