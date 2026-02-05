<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Afficher le feed (page d'accueil)
     */
    public function index()
    {
        $posts = auth()->user()->feed();
        return view('posts.index', compact('posts'));
    }

    /**
     * Afficher le formulaire de création d'un post
     */
    public function create()
    {
        return view('posts.create');
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

        // Incrémenter le compteur de posts de l'utilisateur
        auth()->user()->increment('posts_count');

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post créé avec succès !');
    }

    /**
     * Afficher un post spécifique
     */
    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'likes']);
        return view('posts.show', compact('post'));
    }

    /**
     * Supprimer un post
     */
    public function destroy(Post $post)
    {
        // Vérifier que l'utilisateur est propriétaire du post
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Action non autorisée.');
        }

        // Supprimer l'image
        Storage::disk('public')->delete($post->image_path);

        // Supprimer le post
        $post->delete();

        // Décrémenter le compteur de posts
        auth()->user()->decrement('posts_count');

        return redirect()->route('dashboard')
            ->with('success', 'Post supprimé avec succès !');
    }
}
