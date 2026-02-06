<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Determine if the user can delete the comment.
     */
    public function delete(User $user, Comment $comment): bool
    {
        // L'utilisateur peut supprimer son propre commentaire
        // OU le propriétaire du post peut supprimer n'importe quel commentaire sur son post
        return $user->id === $comment->user_id || $user->id === $comment->post->user_id;
    }
}
