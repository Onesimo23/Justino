<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Exibir a lista de usuários com seus níveis de acesso
    public function index()
    {
        $users = User::all();  // Obtém todos os usuários
        return view('users.manage', compact('users'));  // Passa os usuários para a view
    }

    public function updateRole(Request $request, User $user)
    {
        // Validação para garantir que o novo nível seja um dos valores definidos
        $request->validate([
            'role' => 'required|in:admin,editor,user',
        ]);

        // Atualiza o nível de acesso do usuário
        $user->role = $request->role;
        $user->save();  // Salva a alteração no banco de dados

        // Redireciona de volta com uma mensagem de sucesso
        return redirect()->route('users.manage')->with('success', 'Nível de acesso atualizado com sucesso!');
    }
    public function __construct()
    {
        // Usando o Gate para verificar se o usuário é admin
        $this->middleware('can:isAdmin');
    }
}
