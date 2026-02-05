<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    // ===== RELATIONS =====

    /**
     * Les participants de la conversation
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'conversation_user')
            ->withPivot('last_read_at')
            ->withTimestamps();
    }

    /**
     * Les messages de la conversation
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->latest();
    }

    /**
     * Le dernier message de la conversation
     */
    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    // ===== MÉTHODES UTILES =====

    /**
     * Vérifier si un utilisateur participe à la conversation
     */
    public function hasParticipant(User $user)
    {
        return $this->participants()->where('user_id', $user->id)->exists();
    }

    /**
     * Obtenir l'autre participant (pour les conversations à 2)
     */
    public function otherParticipant(User $user)
    {
        return $this->participants()->where('user_id', '!=', $user->id)->first();
    }

    /**
     * Marquer la conversation comme lue pour un utilisateur
     */
    public function markAsRead(User $user)
    {
        $this->participants()->updateExistingPivot($user->id, [
            'last_read_at' => now()
        ]);
    }

    /**
     * Obtenir le nombre de messages non lus pour un utilisateur
     */
    public function unreadCount(User $user)
    {
        $lastReadAt = $this->participants()
            ->where('user_id', $user->id)
            ->first()
            ->pivot
            ->last_read_at;

        return $this->messages()
            ->where('user_id', '!=', $user->id)
            ->where('created_at', '>', $lastReadAt ?? now()->subYears(10))
            ->count();
    }
}
