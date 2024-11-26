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

    // Função para armazenar um novo post
    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);
    
        // Autoriza a criação do post com base na policy
        $this->authorize('create', Post::class);

        // Criação do novo post com dados válidos
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $request->user_id,
        ]);
    
        // Redirecionamento após a criação
        return redirect()->route('posts.index')->with('success', 'Post criado com sucesso!');
    }

    // Função para editar um post
    public function edit($id)
    {
        // Recupera o post específico
        $post = Post::findOrFail($id);

        // Verifica se o usuário tem permissão para editar
        $this->authorize('update', $post);
    
        // Recupera todos os usuários
        $users = User::all();
    
        return response()->json([
            'post' => $post,
            'users' => $users
        ]);
    }

    // Função para atualizar o post
    public function update(Request $request, $id)
    {
        // Validação dos dados do formulário
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);
    
        // Encontra o post específico
        $post = Post::findOrFail($id);

        // Autoriza a atualização com base na policy
        $this->authorize('update', $post);

        // Atualiza o post com os novos dados
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
        // Encontra o post específico
        $post = Post::findOrFail($id);

        // Autoriza a exclusão com base na policy
        $this->authorize('delete', $post);

        // Exclui o post
        $post->delete();

        // Redireciona de volta para a página de listagem
        return redirect()->route('posts.index');
    }
    public function __construct()
{
    // Usando políticas para verificar se o usuário tem permissão
    $this->middleware('can:update,post')->only('edit', 'update');
    $this->middleware('can:delete,post')->only('destroy');
}
}
