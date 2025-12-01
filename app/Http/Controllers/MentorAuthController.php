<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorAuthController extends Controller
{
    public function showLoginForm()
    {
        // Verifica se já está logado como MENTOR
        if (Auth::guard('mentor')->check()) {
            return redirect()->route('mentor.dashboard');
        }
        return view('mentor.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'E-mail obrigatório',
            'password.required' => 'Senha obrigatória'
        ]);

        // Tenta logar usando o guard 'mentor'
        // Verifica também se status é 'ativo'
        if (Auth::guard('mentor')->attempt([
            'email' => $request->email,
            'password' => $request->password,
            'status' => 'ativo'
        ])) {
            $request->session()->regenerate();
            return redirect()->route('mentor.dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas ou conta inativa.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('mentor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('mentor.login');
    }
}
