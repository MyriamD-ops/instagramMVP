<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Suivre ou ne plus suivre un utilisateur
     */
    public function toggle(User $user)
    {
        $currentUser = auth()->user();

        // On ne peut pas se suivre soi-même
        if ($currentUser->id === $user->id) {
            return response()->json([
                'message' => 'Vous ne pouvez pas vous suivre vous-même.'
            ], 400);
        }

        if ($currentUser->isFollowing($user)) {
            // Unfollow
            $currentUser->unfollow($user);
            $isFollowing = false;
        } else {
            // Follow
            $currentUser->follow($user);
            $isFollowing = true;
        }

        return response()->json([
            'is_following' => $isFollowing,
            'followers_count' => $user->followers_count,
        ]);
    }

    /**
     * Récupérer les followers d'un utilisateur
     */
    public function followers(User $user)
    {
        $followers = $user->followers()->paginate(20);
        
        return response()->json($followers);
    }

    /**
     * Récupérer les utilisateurs suivis
     */
    public function following(User $user)
    {
        $following = $user->following()->paginate(20);
        
        return response()->json($following);
    }
}
