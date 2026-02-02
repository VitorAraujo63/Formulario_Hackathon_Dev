<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class MentorPerfilController extends Controller
{
    public function index()
    {
        return view('mentor.perfil.index', ['mentor' => Auth::guard('mentor')->user()]);
    }

    public function update(Request $request)
    {
        $mentor = Auth::guard('mentor')->user();

        $request->validate([
            'nome' => 'required|string|max:255',
            'password' => 'nullable|min:6|confirmed',
            'foto' => 'nullable|image|max:2048', // Max 2MB
        ]);

        // 1. Atualizar Nome
        $mentor->nome = $request->nome;

        // 2. Atualizar Senha (se preenchida)
        if ($request->filled('password')) {
            $mentor->password = Hash::make($request->password);
        }

        // 3. Processar Foto
        if ($request->hasFile('foto')) {
            try {
                // Converte para WebP 400x400 (Otimização extrema)
                $img = Image::read($request->file('foto'))
                    ->cover(400, 400)
                    ->toWebp(80);

                $nomeArquivo = 'fotos/' . uniqid() . '.webp';

                // Upload para SeaweedFS VPS (Porta 8333)
                Storage::disk('s3')->put($nomeArquivo, (string) $img);

                // Deletar foto antiga se existir
                if ($mentor->foto) {
                    Storage::disk('s3')->delete($mentor->foto);
                }

                $mentor->foto = $nomeArquivo;
            } catch (\Exception $e) {
                return back()->withErrors(['foto' => 'Falha no upload para o servidor: ' . $e->getMessage()]);
            }
        }

        $mentor->save();

        return back()->with('success', 'Perfil atualizado com sucesso!');
    }
}
