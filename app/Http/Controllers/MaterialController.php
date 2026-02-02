<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function download($path)
    {
        // 1. Segurança: Verifica se o usuário está logado
        if (!Auth::guard('aluno')->check() && !Auth::guard('mentor')->check()) {
            abort(403, 'Acesso não autorizado.');
        }

        // 2. Verifica se o arquivo existe no SeaweedFS (S3)
        // Nota: O $path virá como "aulas/4/arquivo.pdf"
        if (!Storage::disk('s3')->exists($path)) {
            abort(404, 'Arquivo não encontrado.');
        }

        try {
            // 3. Retorna o arquivo via Proxy (Laravel lê e entrega ao navegador)
            // O método ->response() tenta abrir no navegador (bom para PDF)
            // Se quiser forçar download, use ->download($path)
            return Storage::disk('s3')->download($path);

        } catch (\Exception $e) {
            \Log::error("Erro ao baixar material: " . $e->getMessage());
            abort(500, 'Erro ao recuperar o arquivo.');
        }
    }
}
