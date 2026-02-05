<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    /**
     * Afficher toutes les conversations de l'utilisateur
     */
    public function index()
    {
        $conversations = auth()->user()->conversations()
            ->with(['lastMessage', 'participants'])
            ->latest('updated_at')
            ->get();

        return view('conversations.index', compact('conversations'));
    }

    /**
     * Afficher une conversation spécifique
     */
    public function show(Conversation $conversation)
    {
        // Vérifier que l'utilisateur fait partie de la conversation
        if (!$conversation->hasParticipant(auth()->user())) {
            abort(403, 'Accès non autorisé.');
        }

        $messages = $conversation->messages()
            ->with('user')
            ->oldest()
            ->get();

        // Marquer comme lu
        $conversation->markAsRead(auth()->user());

        $otherUser = $conversation->otherParticipant(auth()->user());

        return view('conversations.show', compact('conversation', 'messages', 'otherUser'));
    }

    /**
     * Créer ou obtenir une conversation avec un utilisateur
     */
    public function getOrCreate(User $user)
    {
        // Ne pas créer de conversation avec soi-même
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas discuter avec vous-même.');
        }

        // Chercher si une conversation existe déjà entre ces deux utilisateurs
        $conversation = Conversation::whereHas('participants', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->whereHas('participants', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->first();

        // Si aucune conversation n'existe, en créer une
        if (!$conversation) {
            $conversation = Conversation::create();
            $conversation->participants()->attach([auth()->id(), $user->id]);
        }

        return redirect()->route('conversations.show', $conversation);
    }
}
