<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPrivateProfile
{
    /**
     * Vérifie si l'utilisateur peut voir le profil/posts d'un utilisateur privé
     */
    public function handle(Request $request, Closure $next): Response
    {
        $profileUser = $request->route('user');
        $currentUser = auth()->user();

        // Si le profil est privé
        if ($profileUser && $profileUser->is_private) {
            // L'utilisateur peut voir son propre profil
            if ($currentUser && $currentUser->id === $profileUser->id) {
                return $next($request);
            }

            // Vérifier si l'utilisateur suit le profil privé
            if (!$currentUser || !$currentUser->isFollowing($profileUser)) {
                return response()->json([
                    'message' => 'Ce profil est privé.'
                ], 403);
            }
        }

        return $next($request);
    }
}
