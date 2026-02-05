<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'caption',
        'image_path',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // ===== RELATIONS =====

    /**
     * L'utilisateur propriétaire du post
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Les likes du post
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Les commentaires du post
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    // ===== MÉTHODES UTILES =====

    /**
     * Vérifier si un utilisateur a liké ce post
     */
    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Incrémenter le compteur de likes
     */
    public function incrementLikesCount()
    {
        $this->increment('likes_count');
    }

    /**
     * Décrémenter le compteur de likes
     */
    public function decrementLikesCount()
    {
        $this->decrement('likes_count');
    }

    /**
     * Incrémenter le compteur de commentaires
     */
    public function incrementCommentsCount()
    {
        $this->increment('comments_count');
    }

    /**
     * Décrémenter le compteur de commentaires
     */
    public function decrementCommentsCount()
    {
        $this->decrement('comments_count');
    }
}
