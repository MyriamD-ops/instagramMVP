<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        return response()->json([
            'liked' => $liked,
            'likes_count' => $post->likes_count,
        ]);
    }
}
