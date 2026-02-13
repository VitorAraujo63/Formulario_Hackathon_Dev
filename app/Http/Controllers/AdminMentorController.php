<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\SystemLog; // Certifique-se de ter criado este Model no passo anterior
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Permission;

class AdminMentorController extends Controller
{
    /**
     * Lista todos os mentores e os logs do sistema.
     * TODOS os mentores podem visualizar.
     * Apenas quem tem 'gerenciar_equipe' pode editar/excluir.
     */
    public function index()
    {
        $mentores = Mentor::with('permissions')->get();

        // Busca todas as permissões para exibir no modal
        $todasPermissoes = Permission::all()->groupBy('group');

        // Busca os logs do sistema com o relacionamento do mentor
        $logs = SystemLog::with('mentor')
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return view('mentor.admin.index', compact('mentores', 'todasPermissoes', 'logs'));
    }

    /**
     * Cria um novo mentor no banco de dados.
     */
    public function store(Request $request)
    {
        // Verifica permissão de gerenciar equipe
        $user = Auth::guard('mentor')->user();
        if (!$user->hasPermission('gerenciar_equipe')) {
            return back()->with('error', 'Você não tem permissão para cadastrar mentores.');
        }

        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:mentores,email',
            'password' => 'required|min:6',
            'funcao' => 'required|string'
        ]);

        $mentor = Mentor::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Criptografa a senha
            'funcao' => $request->funcao,
            'status' => 'ativo',
        ]);

        // Grava no Log
        $this->registrarLog('Criação', "Cadastrou o mentor: {$mentor->nome} ({$mentor->email})");

        return back()->with('success', 'Novo mentor cadastrado com sucesso!');
    }

    /**
     * Atualiza os dados de um mentor existente.
     */
    public function update(Request $request, $id)
    {
        // Verifica permissão de gerenciar equipe
        $user = Auth::guard('mentor')->user();
        if (!$user->hasPermission('gerenciar_equipe')) {
            return back()->with('error', 'Você não tem permissão para editar mentores.');
        }

        $mentor = Mentor::findOrFail($id);

        $request->validate([
            'nome' => 'required|string',
            'email' => "required|email|unique:mentores,email,{$id}",
            'funcao' => 'required|string'
        ]);

        // PROTEÇÃO: Impede desativar a própria conta
        if ($user->id == $id && $request->status === 'inativo') {
            return back()->with('error', 'Você não pode desativar sua própria conta enquanto está logado.');
        }

        // Lógica para alterar senha apenas se o campo for preenchido
        if ($request->filled('password')) {
            $mentor->password = Hash::make($request->password);
        }

        $mentor->update([
            'nome' => $request->nome,
            'email' => $request->email,
            'funcao' => $request->funcao,
            'status' => $request->status ?? $mentor->status,
        ]);

        // Grava no Log
        $this->registrarLog('Edição', "Atualizou dados do mentor: {$mentor->nome}");

        return back()->with('success', 'Dados atualizados.');
    }

    /**
     * Remove um mentor.
     */
    public function destroy($id)
    {
        $user = Auth::guard('mentor')->user();
        
        // Verifica se tem permissão de gerenciar equipe
        if (!$user->hasPermission('gerenciar_equipe')) {
            return back()->with('error', 'Você não tem permissão para excluir mentores.');
        }

        // Segurança: Impede que você exclua sua própria conta logada
        if ($user->id == $id) {
            return back()->with('error', 'Você não pode excluir sua própria conta.');
        }

        $mentor = Mentor::findOrFail($id);
        $nomeBkp = $mentor->nome;

        $mentor->delete();

        // Grava no Log
        $this->registrarLog('Exclusão', "Removeu o mentor: {$nomeBkp}");

        return back()->with('success', 'Mentor removido.');
    }

    /**
     * Função auxiliar privada para registrar logs.
     */
    private function registrarLog($acao, $descricao)
    {
        SystemLog::create([
            'mentor_id' => Auth::guard('mentor')->id(),
            'acao' => $acao,
            'descricao' => $descricao,
            'ip_address' => request()->ip()
        ]);
    }

    public function updatePermissions(Request $request, $id)
    {
        $user = Auth::guard('mentor')->user();
        
        // Verifica se tem permissão de gerenciar equipe
        if (!$user->hasPermission('gerenciar_equipe')) {
            abort(403, 'Você não tem permissão para gerenciar acessos.');
        }

        $mentor = Mentor::findOrFail($id);

        // PROTEÇÃO: Não permite editar permissões de Admins
        if ($mentor->isAdmin()) {
            return back()->with('error', 'Administradores possuem todas as permissões automaticamente e não podem ser editadas.');
        }

        // Sincroniza permissões
        $mentor->permissions()->sync($request->permissions ?? []);

        // Grava no Log
        $this->registrarLog('Permissões', "Alterou as permissões de: {$mentor->nome}");

        return back()->with('success', 'Permissões atualizadas com sucesso!');
    }
}
