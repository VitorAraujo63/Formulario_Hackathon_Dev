<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use App\Models\AulaRecurso;
use App\Models\AulaCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AulaController extends Controller
{
    public function index()
    {
        $aulas = Aula::with(['categoria', 'recursos'])->latest()->get();
        $categorias = AulaCategoria::all();

        // Corrija aqui se estiver diferente
        return view('mentor.aulas.index', compact('aulas', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'aula_categoria_id' => 'required|exists:aula_categorias,id',
            'arquivos.*' => 'nullable|file|max:20480', // Max 20MB por arquivo
        ]);

        // 1. Cria a Aula
        $aula = Aula::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'aula_categoria_id' => $request->aula_categoria_id,
            'data_prevista' => $request->data_prevista,
            'publicada' => $request->has('publicada'),
        ]);

        // 2. Processa Arquivos (SeaweedFS)
        if ($request->hasFile('arquivos')) {
            foreach ($request->file('arquivos') as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                // Nome único para evitar sobrescrita
                $fileName = Str::random(15) . '.' . $extension;
                $path = "aulas/{$aula->id}/{$fileName}";

                Storage::disk('s3')->put($path, file_get_contents($file));

                $aula->recursos()->create([
                    'titulo' => $originalName,
                    'tipo' => 'arquivo',
                    'path' => $path,
                    'extensao' => $extension
                ]);
            }
        }

        // 3. Processa Links (URLs externas)
        if ($request->links) {
            foreach ($request->links as $index => $url) {
                if ($url) {
                    $aula->recursos()->create([
                        'titulo' => $request->link_titulos[$index] ?? 'Link de Apoio',
                        'tipo' => 'link',
                        'path' => $url,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Aula criada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $aula = Aula::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'aula_categoria_id' => 'required|exists:aula_categorias,id',
            'arquivos.*' => 'nullable|file|max:20480',
        ]);

        // 1. Atualiza dados básicos
        $aula->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'aula_categoria_id' => $request->aula_categoria_id,
            'data_prevista' => $request->data_prevista,
            'publicada' => $request->has('publicada'), // Checkbox marcado = true
        ]);

        // 2. Se enviou NOVOS arquivos, adiciona (não substitui os antigos)
        if ($request->hasFile('arquivos')) {
            foreach ($request->file('arquivos') as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileName = Str::random(15) . '.' . $extension;
                $path = "aulas/{$aula->id}/{$fileName}";

                Storage::disk('s3')->put($path, file_get_contents($file));

                $aula->recursos()->create([
                    'titulo' => $originalName,
                    'tipo' => 'arquivo',
                    'path' => $path,
                    'extensao' => $extension
                ]);
            }
        }

        // 3. Se enviou NOVOS links
        if ($request->links) {
            foreach ($request->links as $index => $url) {
                if ($url) {
                    $aula->recursos()->create([
                        'titulo' => $request->link_titulos[$index] ?? 'Link de Apoio',
                        'tipo' => 'link',
                        'path' => $url,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Aula atualizada com sucesso!');
    }

    public function destroy($id)
    {
        // BUSCAR PRIMEIRO (Isso permite que o Model dispare o evento de limpeza)
        $aula = Aula::findOrFail($id);

        // AO CHAMAR ISSO, O CÓDIGO DO 'booted' LÁ EM CIMA É EXECUTADO AUTOMATICAMENTE
        $aula->delete();

        return redirect()->back()->with('success', 'Aula e arquivos removidos com sucesso!');
    }
}
