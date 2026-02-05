<?php

namespace App\Http\Controllers;

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
            return back()->with('error', 'Vous ne pouvez pas vous suivre vous-même.');
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

        // Si c'est une requête AJAX, retourner JSON
        if (request()->wantsJson()) {
            return response()->json([
                'is_following' => $isFollowing,
                'followers_count' => $user->followers_count,
            ]);
        }

        return back();
    }

    /**
     * Afficher les followers d'un utilisateur
     */
    public function followers(User $user)
    {
        $followers = $user->followers()->paginate(20);
        return view('users.followers', compact('user', 'followers'));
    }

    /**
     * Afficher les utilisateurs suivis
     */
    public function following(User $user)
    {
        $following = $user->following()->paginate(20);
        return view('users.following', compact('user', 'following'));
    }
}
