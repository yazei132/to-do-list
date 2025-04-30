<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Adicionando o Facade Auth
use App\Models\User;

class AuthController extends Controller
{
    // Mostrar o formulário de login
    public function showLogin() {
        return view('auth.login');
    }

    // Processar o login
    public function login(Request $request) {
        // Validar os dados de entrada
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Buscar o usuário pelo email
        $user = User::where('email', $request->email)->first();

        // Verificar se o usuário não foi encontrado
        if (!$user) {
            // Redirecionar com uma mensagem de erro
            return redirect()->route('login')->with('error', 'Usuário não encontrado, por favor registre-se.');
        }

        // Verificar se a senha está correta
        if (!Hash::check($request->password, $user->password)) {
            // Redirecionar com uma mensagem de erro
            return redirect()->route('login')->with('error', 'Credenciais inválidas. Tente novamente.');
        }

        // Fazer login do usuário
        Auth::login($user);

        // Redirecionar para a página inicial ou outra página segura
        return redirect()->route('home');  // Aqui você pode redirecionar para a página desejada
    }

    // Mostrar o formulário de registro
    public function showRegister() {
        return view('auth.register');
    }

    // Processar o registro de um novo usuário
    public function register(Request $request) {
        // Validar os dados de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        // Criar o novo usuário
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirecionar para a página de login com mensagem de sucesso
        return redirect()->route('login')->with('success', 'Registro realizado com sucesso!');
    }
}
