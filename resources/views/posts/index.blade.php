<!-- resources/views/posts/index.blade.php -->
@extends('layouts.app')

@section('content')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<h1 class="mb-4">Gerenciamento de Posts</h1>

<!-- Nav Tabs para organizar as seções -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="create-post-tab" data-bs-toggle="tab" href="#create-post" role="tab" aria-controls="create-post" aria-selected="true">Criar e Ver Posts</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="lazy-loading-tab" data-bs-toggle="tab" href="#lazy-loading" role="tab" aria-controls="lazy-loading" aria-selected="false">Lazy Loading</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="eager-loading-tab" data-bs-toggle="tab" href="#eager-loading" role="tab" aria-controls="eager-loading" aria-selected="false">Eager Loading</a>
    </li>
</ul>

<div class="tab-content mt-3" id="myTabContent">
    <!-- Criar e Ver Posts Tab -->
    <div class="tab-pane fade show active" id="create-post" role="tabpanel" aria-labelledby="create-post-tab">
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createPostModal">
            Criar Novo Post
        </button>

    
        <h2>Posts Criados:</h2>
        @foreach ($postsLazy as $post)
        <div class="mb-2">
            <strong>{{ $post->title }}</strong> - {{ $post->content }} | Usuário: {{ $post->user->name }}

            @can('update', $post)
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPostModal{{ $post->id }}">
                    Editar
                </button>
            @else
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#unauthorizedModal" data-action="editar">
                    Editar
                </button>
            @endcan

            @can('delete', $post)
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                </form>
            @else
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#unauthorizedModal" data-action="deletar">
                    Excluir
                </button>
            @endcan
        </div>

        <!-- Modal para edição de post -->
        <div class="modal fade" id="editPostModal{{ $post->id }}" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPostModalLabel">Editar Post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('posts.update', $post->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="title" class="form-label">Título</label>
                                <input type="text" class="form-control" name="title" value="{{ $post->title }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Conteúdo</label>
                                <textarea class="form-control" name="content" rows="3" required>{{ $post->content }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="user_id" class="form-label">Usuário</label>
                                <select class="form-select" name="user_id" required>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $post->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Salvar Mudanças</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
    </div>

    <!-- Lazy Loading Tab -->
    <div class="tab-pane fade" id="lazy-loading" role="tabpanel" aria-labelledby="lazy-loading-tab">
        <h2>Posts com Lazy Loading:</h2>
        <div class="alert alert-info" style="font-size: 0.85rem;">
            <strong>Lazy Loading:</strong> Carrega os posts inicialmente, e os dados relacionados (como usuários) são carregados somente quando acessados. Isso pode gerar várias consultas ao banco, uma para cada post.
        </div>
        @foreach ($postsLazy as $post)
            <div class="mb-2">
                <strong>{{ $post->title }}</strong> - {{ $post->content }}
            </div>
        @endforeach
    </div>

    <!-- Eager Loading Tab -->
    <div class="tab-pane fade" id="eager-loading" role="tabpanel" aria-labelledby="eager-loading-tab">
        <h2>Posts com Eager Loading:</h2>
        <div class="alert alert-info" style="font-size: 0.85rem;">
            <strong>Eager Loading:</strong> Carrega os posts junto com seus dados relacionados, como usuários, de uma vez só. Isso reduz o número de consultas ao banco, tornando a consulta mais eficiente quando você já sabe que vai precisar dos dados relacionados.
        </div>
        @foreach ($postsEager as $post)
            <div class="mb-2">
                <strong>{{ $post->title }}</strong> - {{ $post->content }} | Usuário: {{ $post->user->name }}
            </div>
        @endforeach
    </div>
</div>

<!-- Modal para criar um novo post -->
<div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPostModalLabel">Criar Novo Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('posts.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Conteúdo</label>
                        <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Usuário</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar Post</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal de Permissão Negada -->
<div class="modal fade" id="unauthorizedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ação Não Permitida</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Você não tem permissão para <span id="action"></span> este post. Por favor, contate o administrador para mais informações.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <a href="javascript:history.back()" class="btn btn-primary">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Modificar o texto do modal de acordo com a ação
    $('#unauthorizedModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var action = button.data('action');
        var modal = $(this);
        modal.find('.modal-body #action').text(action);
    });
</script>

@endsection
