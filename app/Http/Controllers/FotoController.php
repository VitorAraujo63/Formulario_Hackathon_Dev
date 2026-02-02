<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class FotoController extends Controller
{
    // Método existente (Mentores)
    public function show($filename)
    {
        return $this->serveImage("fotos/" . $filename);
    }

    // NOVO MÉTODO (Alunos)
    public function showAluno($filename)
    {
        // Aponta para a pasta onde salvamos no controller acima
        return $this->serveImage("fotos_alunos/" . $filename);
    }

    // Função privada auxiliar para não repetir código
    private function serveImage($path)
    {
        try {
            if (!Storage::disk('s3')->exists($path)) {
                return redirect("https://ui-avatars.com/api/?name=Error&background=random");
            }

            $file = Storage::disk('s3')->get($path);
            $type = Storage::disk('s3')->mimeType($path);

            return response($file)->header('Content-Type', $type);

        } catch (\Exception $e) {
            // Se der erro, NÃO mostramos o erro na tela.
            // Nós apenas gravamos no Log interno do servidor...
            \Log::error("Erro S3: " . $e->getMessage());

            // ...e redirecionamos o usuário para um avatar genérico.
            return redirect("https://ui-avatars.com...");
        }
    }
}
