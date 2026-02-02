<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Aviso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlunoAvisoController extends Controller
{
    public function index()
    {
        // Busca avisos ordenando por:
        // 1. Fixados primeiro
        // 2. Data de criação (mais novos)
        $avisos = Aviso::with(['mentor', 'curtidas']) // Carrega relações para performance
                       ->orderBy('fixado', 'desc')
                       ->latest()
                       ->get();

        return view('aluno.avisos.index', compact('avisos'));
    }

    public function toggleLike($id)
    {
        $aviso = Aviso::findOrFail($id);
        $alunoId = Auth::guard('aluno')->id();

        // Verifica se o aluno já curtiu este aviso
        $jaCurtiu = $aviso->curtidas()->where('aluno_id', $alunoId)->exists();

        if ($jaCurtiu) {
            // Se já curtiu, remove (Descurtir)
            $aviso->curtidas()->detach($alunoId);
        } else {
            // Se não curtiu, adiciona (Curtir)
            // Adicionamos o created_at manualmente pois sua tabela tem esse campo específico
            $aviso->curtidas()->attach($alunoId, ['created_at' => now()]);
        }

        return back(); // Recarrega a página mantendo a posição
    }
}

