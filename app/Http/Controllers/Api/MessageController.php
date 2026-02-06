<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Envoyer un message dans une conversation
     */
    public function store(Request $request, Conversation $conversation)
    {
        // Vérifier que l'utilisateur fait partie de la conversation
        if (!$conversation->hasParticipant(auth()->user())) {
            return response()->json([
                'message' => 'Accès non autorisé.'
            ], 403);
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $message = $conversation->messages()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        // Mettre à jour le timestamp de la conversation
        $conversation->touch();

        $message->load('user');
        
        return response()->json($message, 201);
    }
}
