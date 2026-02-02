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
     */
    public function index()
    {
        $mentores = Mentor::with('permissions')->get(); // Carrega permissões atuais
        $logs = SystemLog::with('mentor')->latest()->take(20)->get();

        // Busca todas as permissões para exibir no modal
        $todasPermissoes = Permission::all()->groupBy('group');

        return view('mentor.admin.index', compact('mentores', 'logs', 'todasPermissoes'));
    }

    /**
     * Cria um novo mentor no banco de dados.
     */
    public function store(Request $request)
    {
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
        $mentor = Mentor::findOrFail($id);

        $request->validate([
            'nome' => 'required|string',
            'email' => "required|email|unique:mentores,email,{$id}", // Ignora o email atual na validação unique
            'funcao' => 'required|string'
        ]);

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
        // Segurança: Impede que você exclua sua própria conta logada
        if (Auth::guard('mentor')->id() == $id) {
            return back()->with('error', 'Você não pode excluir sua própria conta.');
        }

        $mentor = Mentor::findOrFail($id);
        $nomeBkp = $mentor->nome; // Guarda o nome para usar no log após deletar

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
        // Só Admin pode dar permissões
        if (Auth::guard('mentor')->user()->funcao !== 'Admin') {
            abort(403, 'Apenas Admins podem gerenciar permissões.');
        }

        $mentor = Mentor::findOrFail($id);

        // Sincroniza (remove as antigas e adiciona as novas marcadas)
        // Se não vier nada no request (nenhuma marcada), ele limpa tudo.
        $mentor->permissions()->sync($request->permissions ?? []);

        // Grava no Log (sua função de log existente)
        $this->registrarLog('Permissões', "Alterou as permissões de acesso de: {$mentor->nome}");

        return back()->with('success', 'Permissões atualizadas com sucesso!');
    }
}
