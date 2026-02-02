<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $table = 'system_logs';

    protected $fillable = ['mentor_id', 'acao', 'descricao', 'ip_address'];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'mentor_id');
    }
}
