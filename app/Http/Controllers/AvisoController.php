<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AvisoController extends Controller
{
    public function index()
    {
        // Ordena por Fixado primeiro, depois Data de Criação
        $avisos = Aviso::with('curtidas')
                        ->orderBy('fixado', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('mentor.avisos.index', compact('avisos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required|string',
            'imagem' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $data = $request->only(['titulo', 'conteudo']);

        // Define os campos obrigatórios e booleanos
        $data['mentor_id'] = Auth::guard('mentor')->id();
        $data['fixado'] = $request->has('fixado');
        $data['visivel_todos'] = true; // Padrão da sua migration

        // Upload de imagem
        if ($request->hasFile('imagem')) {
            $data['imagem'] = $request->file('imagem')->store('avisos', 'public');
        }

        Aviso::create($data);

        return back()->with('success', 'Aviso publicado no mural!');
    }

    public function update(Request $request, $id)
    {
        $aviso = Aviso::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'conteudo' => 'required|string',
        ]);

        $aviso->titulo = $request->titulo;
        $aviso->conteudo = $request->conteudo;
        $aviso->fixado = $request->has('fixado');

        if ($request->hasFile('imagem')) {
            // Apaga a imagem antiga se existir e o usuário enviou uma nova
            if ($aviso->imagem) {
                Storage::disk('public')->delete($aviso->imagem);
            }
            $aviso->imagem = $request->file('imagem')->store('avisos', 'public');
        }

        $aviso->save();

        return back()->with('success', 'Aviso atualizado!');
    }

    public function destroy($id)
    {
        $aviso = Aviso::findOrFail($id);

        // Remove a imagem do disco para não ocupar espaço à toa
        if ($aviso->imagem) {
            Storage::disk('public')->delete($aviso->imagem);
        }

        $aviso->delete();

        return back()->with('success', 'Aviso removido.');
    }
}
