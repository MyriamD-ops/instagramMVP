<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Afficher le profil d'un utilisateur
     */
    public function show(User $user)
    {
        $posts = $user->posts()->paginate(12);
        
        // Vérifier si l'utilisateur connecté suit cet utilisateur
        $isFollowing = auth()->check() && auth()->user()->isFollowing($user);
        
        return view('users.show', compact('user', 'posts', 'isFollowing'));
    }

    /**
     * Afficher le formulaire d'édition du profil
     */
    public function edit()
    {
        $user = auth()->user();
        return view('users.edit', compact('user'));
    }

    /**
     * Mettre à jour le profil
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:150',
            'website' => 'nullable|url|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_private' => 'boolean',
        ]);

        $data = $request->only(['username', 'name', 'bio', 'website', 'is_private']);

        // Si une nouvelle photo de profil est uploadée
        if ($request->hasFile('profile_picture')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            $data['profile_picture'] = $request->file('profile_picture')
                ->store('profile_pictures', 'public');
        }

        $user->update($data);

        return redirect()->route('users.show', $user)
            ->with('success', 'Profil mis à jour avec succès !');
    }

    /**
     * Rechercher des utilisateurs
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $users = User::where('username', 'like', "%{$query}%")
            ->orWhere('name', 'like', "%{$query}%")
            ->limit(20)
            ->get();

        if ($request->wantsJson()) {
            return response()->json($users);
        }

        return view('users.search', compact('users', 'query'));
    }
}
