<?php
// app/Policies/PostPolicy.php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Verifique se o usuário pode visualizar o post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return bool
     */
    public function view(User $user, Post $post)
    {
        // Admin, editor e user podem ver os posts
        return $user->isAdmin() || $user->isEditor() || $user->isUser();
    }

    /**
     * Verifique se o usuário pode criar um post.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        // Apenas admin e editor podem criar posts
        return $user->isAdmin() || $user->isEditor();
    }

    /**
     * Verifique se o usuário pode atualizar o post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return bool
     */
    public function update(User $user, Post $post)
    {
        // Admin e editor podem atualizar posts, mas apenas admin pode editar os posts de outros
        return $user->isAdmin() || ($user->isEditor() && $user->id === $post->user_id);
    }

    /**
     * Verifique se o usuário pode excluir o post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return bool
     */
    public function delete(User $user, Post $post)
    {
        // Apenas admin pode excluir posts
        return $user->isAdmin();
    }
}
