<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Determine if the user can view the post.
     */
    public function view(?User $user, Post $post): bool
    {
        // Si le post appartient à un compte privé
        if ($post->user->is_private) {
            // L'utilisateur doit être connecté et suivre le propriétaire
            return $user && ($user->id === $post->user_id || $user->isFollowing($post->user));
        }

        // Sinon, tout le monde peut voir
        return true;
    }

    /**
     * Determine if the user can update the post.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * Determine if the user can delete the post.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}
