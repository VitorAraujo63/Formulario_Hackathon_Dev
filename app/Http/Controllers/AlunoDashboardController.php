<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chamada;
use App\Models\Aviso;
use App\Models\Aula;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class AlunoDashboardController extends Controller
{
    public function index()
    {
        $aluno = Auth::guard('aluno')->user();

        // 1. Verifica se tem aula acontecendo AGORA (para o botão de check-in)
        $chamadaAtiva = Chamada::with('mentor')
                               ->where('ativa', true)
                               ->latest()
                               ->first();

        // 2. Estatísticas do Aluno
        $minhasPresencas = $aluno->presencas()->count();

        // Total de aulas dadas no geral (para calcular %)
        // Nota: Isso é uma estimativa global. Pode refinar por turma depois.
        $totalAulasGeral = Chamada::where('ativa', false)->count();
        $frequenciaPercent = $totalAulasGeral > 0 ? round(($minhasPresencas / $totalAulasGeral) * 100) : 100;

        // 3. Últimos Avisos
        $avisos = Aviso::with('mentor')->latest()->take(3)->get();

        // 4. Últimos Materiais
        $materiais = Aula::with('categoria')->where('publicada', true)->latest()->take(3)->get();

        return view('aluno.dashboard', compact('aluno', 'chamadaAtiva', 'minhasPresencas', 'frequenciaPercent', 'avisos', 'materiais'));
    }

    public function materiais()
    {
        // 1. Busca as aulas do banco
        $aulasRaw = Aula::with(['categoria', 'recursos'])
                     ->where('publicada', true)
                     ->latest()
                     ->get();

        // 2. Prepara os dados para a View (Aqui fica toda a lógica chata)
        $aulas = $aulasRaw->map(function($aula) {

            // Cria uma coleção 'recursos_view' formatada para o front-end
            $aula->recursos_view = $aula->recursos->map(function($recurso) {

                $isArquivo = $recurso->tipo == 'arquivo';
                $url = $recurso->path;
                $icon = 'fas fa-link';
                $color = 'text-blue-500';
                $actionText = 'Acessar Link';
                $isSafe = false;

                if ($isArquivo) {
                    // LIMPEZA DO IP: Remove o IP antigo se existir
                    $cleanPath = str_replace('http://72.60.8.197:8888/buckets/mentoria/', '', $recurso->path);
                    $cleanPath = ltrim($cleanPath, '/');

                    // Gera a Rota Proxy
                    $url = route('aluno.material.download', ['path' => $cleanPath]);
                    $actionText = 'Download Seguro';
                    $isSafe = true;

                    // Define Ícones por extensão
                    $ext = strtolower(pathinfo($recurso->path, PATHINFO_EXTENSION));
                    if ($ext === 'pdf') {
                        $icon = 'fas fa-file-pdf'; $color = 'text-red-500';
                    } elseif (in_array($ext, ['zip', 'rar', '7z'])) {
                        $icon = 'fas fa-file-archive'; $color = 'text-amber-500';
                    } else {
                        $icon = 'fas fa-file-alt'; $color = 'text-blue-500';
                    }
                }
                // Ícones para Links Externos
                elseif (\Illuminate\Support\Str::contains($recurso->path, 'github.com')) {
                    $icon = 'fab fa-github'; $color = 'text-slate-800';
                } elseif (\Illuminate\Support\Str::contains($recurso->path, ['youtube.com', 'youtu.be'])) {
                    $icon = 'fab fa-youtube'; $color = 'text-red-600';
                } elseif (\Illuminate\Support\Str::contains($recurso->path, 'canva.com')) {
                    $icon = 'fas fa-palette'; $color = 'text-blue-400';
                }

                // Retorna um objeto simples para a View ler
                return (object) [
                    'titulo' => $recurso->titulo,
                    'url' => $url,
                    'icon' => $icon,
                    'color' => $color,
                    'action_text' => $actionText,
                    'is_safe' => $isSafe
                ];
            });

            return $aula;
        });

        return view('aluno.materiais.materiais', compact('aulas'));
    }

    public function frequencia()
    {
        $presencas = Auth::guard('aluno')->user()
                         ->presencas()
                         // ERRO ESTAVA AQUI: ->with('chamada')
                         // CORREÇÃO: Carregamos o 'mentor', pois a 'chamada' já é o próprio objeto
                         ->with('mentor')
                         ->orderByPivot('registrado_em', 'desc')
                         ->get();

        return view('aluno.frequencia.frequencia', compact('presencas'));
    }

    // Métodos de Perfil
    public function perfil()
    {
        $aluno = Auth::guard('aluno')->user();
        return view('aluno.perfil.index', compact('aluno'));
    }

    public function updatePerfil(Request $request)
    {
        $aluno = Auth::guard('aluno')->user();

        $request->validate([
            'nome_completo' => 'required|string|max:255',
            'telefone_aluno' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:5120', // Max 5MB
        ]);

        // 1. Atualizar Dados Básicos
        $aluno->nome_completo = $request->nome_completo;
        $aluno->telefone_aluno = $request->telefone_aluno;

        // 2. Processar Foto (Padrão Mentor)
        if ($request->hasFile('foto')) {
            try {
                // Lê a imagem e converte (Resize 400x400 + WebP)
                $img = Image::read($request->file('foto'))
                    ->cover(400, 400)
                    ->toWebp(80);

                // Define nome e pasta (usaremos 'fotos_alunos' para organizar)
                $nomeArquivo = 'fotos_alunos/' . uniqid() . '.webp';

                // Upload via Driver S3 (Porta 8333)
                Storage::disk('s3')->put($nomeArquivo, (string) $img);

                // Deletar foto antiga se existir
                if ($aluno->foto && Storage::disk('s3')->exists($aluno->foto)) {
                    Storage::disk('s3')->delete($aluno->foto);
                }

                $aluno->foto = $nomeArquivo;

            } catch (\Exception $e) {
                return back()->withErrors(['foto' => 'Falha ao processar imagem: ' . $e->getMessage()]);
            }
        }

        $aluno->save();

        return back()->with('sucesso', 'Perfil atualizado com sucesso!');
    }
}
