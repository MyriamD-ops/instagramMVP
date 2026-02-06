<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Récupérer les commentaires d'un post
     */
    public function index(Post $post)
    {
        $comments = $post->comments()
            ->with('user')
            ->latest()
            ->paginate(20);
            
        return response()->json($comments);
    }

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

        $comment->load('user');
        
        return response()->json([
            'comment' => $comment,
            'comments_count' => $post->comments_count,
        ], 201);
    }

    /**
     * Supprimer un commentaire
     */
    public function destroy(Post $post, $commentId)
    {
        $comment = $post->comments()->findOrFail($commentId);

        // Vérifier que l'utilisateur est propriétaire du commentaire
        if ($comment->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Action non autorisée.'
            ], 403);
        }

        $comment->delete();

        // Décrémenter le compteur de commentaires
        $post->decrementCommentsCount();

        return response()->json([
            'message' => 'Commentaire supprimé avec succès.'
        ]);
    }
}
