<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Liker ou unliker un post
     */
    public function toggle(Post $post)
    {
        $user = auth()->user();

        if ($user->hasLiked($post)) {
            // Unliker
            $user->likes()->where('post_id', $post->id)->delete();
            $post->decrementLikesCount();
            $liked = false;
        } else {
            // Liker
            $user->likes()->create([
                'post_id' => $post->id,
            ]);
            $post->incrementLikesCount();
            $liked = true;
        }

        // Si c'est une requête AJAX, retourner JSON
        if (request()->wantsJson()) {
            return response()->json([
                'liked' => $liked,
                'likes_count' => $post->likes_count,
            ]);
        }

        return back();
    }
}
