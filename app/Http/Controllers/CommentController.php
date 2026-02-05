<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Créer un commentaire
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        // Incrémenter le compteur de commentaires
        $post->incrementCommentsCount();

        // Si c'est une requête AJAX, retourner le commentaire
        if ($request->wantsJson()) {
            $comment->load('user');
            return response()->json([
                'comment' => $comment,
                'comments_count' => $post->comments_count,
            ]);
        }

        return back()->with('success', 'Commentaire ajouté !');
    }

    /**
     * Supprimer un commentaire
     */
    public function destroy(Post $post, $commentId)
    {
        $comment = $post->comments()->findOrFail($commentId);

        // Vérifier que l'utilisateur est propriétaire du commentaire
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'Action non autorisée.');
        }

        $comment->delete();

        // Décrémenter le compteur de commentaires
        $post->decrementCommentsCount();

        return back()->with('success', 'Commentaire supprimé !');
    }
}
