<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'user_id',
        'content',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];

    // ===== RELATIONS =====

    /**
     * La conversation du message
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * L'utilisateur qui a envoyé le message
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
