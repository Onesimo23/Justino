<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Função para exibir todos os posts (Lazy Loading e Eager Loading)
    public function index()
    {
        // Lazy Loading: Carrega os posts e carrega o usuário depois, quando necessário
        $postsLazy = Post::all();
        
        // Eager Loading: Carrega os posts e os usuários de uma vez
        $postsEager = Post::with('user')->get();
        
        // Recupera todos os usuários para os formulários de criação e edição de posts
        $users = User::all();

        // Retorna a view com os dados dos posts e usuários
        return view('posts.index', compact('postsLazy', 'postsEager', 'users'));
    }

    // Função para criar um novo post
    public function create()
    {
        // Recupera todos os usuários para associar ao post
        $users = User::all();
        return response()->json(['users' => $users]);
    }

    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);
    
        // Criação do novo post com dados válidos
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $request->user_id,
        ]);
    
        // Redirecionamento após a criação
        return redirect()->route('posts.index')->with('success', 'Post criado com sucesso!');
    }
    

    public function edit($id)
    {
        // Recupera o post específico
        $post = Post::findOrFail($id);
    
        // Recupera todos os usuários
        $users = User::all();
    
        return response()->json([
            'post' => $post,
            'users' => $users
        ]);
    }
    

    public function update(Request $request, $id)
    {
        // Validação dos dados do formulário
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);
    
        // Encontrando o post e atualizando com os novos dados
        $post = Post::findOrFail($id);
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $request->user_id,
        ]);
    
        // Redirecionamento após a atualização
        return redirect()->route('posts.index')->with('success', 'Post atualizado com sucesso!');
    }
    

    // Função para excluir um post
    public function destroy($id)
    {
        // Encontra e deleta o post
        Post::findOrFail($id)->delete();

        // Redireciona de volta para a página de listagem
        return redirect()->route('posts.index');
    }
}
