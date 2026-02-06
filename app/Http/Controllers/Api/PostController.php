<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Récupérer le feed de l'utilisateur
     */
    public function index()
    {
        $posts = auth()->user()->feed();
        
        return response()->json($posts);
    }

    /**
     * Récupérer les posts d'un utilisateur spécifique
     */
    public function userPosts($userId)
    {
        $posts = Post::where('user_id', $userId)
            ->with(['user', 'likes', 'comments'])
            ->latest()
            ->paginate(12);
            
        return response()->json($posts);
    }

    /**
     * Créer un nouveau post
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:2200',
        ]);

        // Sauvegarder l'image
        $imagePath = $request->file('image')->store('posts', 'public');

        // Créer le post
        $post = auth()->user()->posts()->create([
            'image_path' => $imagePath,
            'caption' => $request->caption,
        ]);

        // Incrémenter le compteur de posts
        auth()->user()->increment('posts_count');

        return response()->json($post->load(['user', 'likes', 'comments']), 201);
    }

    /**
     * Afficher un post spécifique
     */
    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'likes']);
        
        return response()->json($post);
    }

    /**
     * Supprimer un post
     */
    public function destroy(Post $post)
    {
        // Vérifier que l'utilisateur est propriétaire du post
        if ($post->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Action non autorisée.'
            ], 403);
        }

        // Supprimer l'image
        Storage::disk('public')->delete($post->image_path);

        // Supprimer le post
        $post->delete();

        // Décrémenter le compteur de posts
        auth()->user()->decrement('posts_count');

        return response()->json([
            'message' => 'Post supprimé avec succès.'
        ]);
    }
}
