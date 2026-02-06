<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Les attributs qui peuvent être assignés en masse
     */
    protected $fillable = [
        'user_id',
        'caption',
        'image_path',
        'likes_count',
        'comments_count',
    ];

    /**
     * Les attributs qui doivent être cachés pour les tableaux
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Les attributs qui doivent être castés
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'likes_count' => 'integer',
        'comments_count' => 'integer',
    ];

    /**
     * Les accesseurs à ajouter au tableau/JSON du modèle
     */
    protected $appends = [
        'image_url',
        'time_ago',
    ];

    /**
     * Les relations à toujours charger avec le modèle
     */
    protected $with = [];

    // ===== RELATIONS =====

    /**
     * L'utilisateur propriétaire du post
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Utilisateur supprimé',
            'username' => 'deleted',
        ]);
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

    /**
     * Les utilisateurs qui ont liké ce post
     */
    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'likes')
            ->withTimestamps();
    }

    // ===== SCOPES =====

    /**
     * Scope pour obtenir uniquement les posts avec images
     */
    public function scopeWithImage($query)
    {
        return $query->whereNotNull('image_path');
    }

    /**
     * Scope pour obtenir les posts populaires (plus de 10 likes)
     */
    public function scopePopular($query)
    {
        return $query->where('likes_count', '>=', 10);
    }

    /**
     * Scope pour obtenir les posts récents (moins de 24h)
     */
    public function scopeRecent($query)
    {
        return $query->where('created_at', '>=', now()->subDay());
    }

    // ===== ACCESSEURS =====

    /**
     * Obtenir l'URL complète de l'image
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return null;
        }

        // Si c'est déjà une URL complète
        if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return $this->image_path;
        }

        // Sinon, générer l'URL depuis le storage
        return Storage::disk('public')->url($this->image_path);
    }

    /**
     * Obtenir le temps écoulé depuis la création du post
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Obtenir la caption tronquée (150 caractères)
     */
    public function getShortCaptionAttribute()
    {
        if (!$this->caption) {
            return null;
        }

        return strlen($this->caption) > 150 
            ? substr($this->caption, 0, 150) . '...' 
            : $this->caption;
    }

    // ===== MÉTHODES UTILES =====

    /**
     * Vérifier si un utilisateur a liké ce post
     */
    public function isLikedBy($user)
    {
        if (!$user) {
            return false;
        }

        $userId = $user instanceof User ? $user->id : $user;
        
        return $this->likes()->where('user_id', $userId)->exists();
    }

    /**
     * Vérifier si l'utilisateur est le propriétaire du post
     */
    public function isOwnedBy($user)
    {
        if (!$user) {
            return false;
        }

        $userId = $user instanceof User ? $user->id : $user;
        
        return $this->user_id === $userId;
    }

    /**
     * Toggle like pour un utilisateur
     */
    public function toggleLike(User $user)
    {
        if ($this->isLikedBy($user)) {
            // Contrairement à unlike
            $this->unlike($user);
            return false;
        } else {
            // Like
            $this->like($user);
            return true;
        }
    }

    /**
     * Liker le post
     */
    public function like(User $user)
    {
        if (!$this->isLikedBy($user)) {
            $this->likes()->create([
                'user_id' => $user->id,
            ]);
            $this->increment('likes_count');
        }
    }

    /**
     * Unliker le post
     */
    public function unlike(User $user)
    {
        if ($this->isLikedBy($user)) {
            $this->likes()->where('user_id', $user->id)->delete();
            $this->decrement('likes_count');
        }
    }

    /**
     * Ajouter un commentaire au post
     */
    public function addComment(User $user, string $content)
    {
        $comment = $this->comments()->create([
            'user_id' => $user->id,
            'content' => $content,
        ]);

        $this->increment('comments_count');

        return $comment;
    }

    /**
     * Supprimer un commentaire du post
     */
    public function removeComment(Comment $comment)
    {
        if ($comment->post_id === $this->id) {
            $comment->delete();
            $this->decrement('comments_count');
        }
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

    // ===== ÉVÉNEMENTS =====

    /**
     * Les événements du cycle de vie du modèle
     */
    protected static function boot()
    {
        parent::boot();

        // Avant de supprimer un post
        static::deleting(function ($post) {
            // Supprimer l'image du storage
            if ($post->image_path && Storage::disk('public')->exists($post->image_path)) {
                Storage::disk('public')->delete($post->image_path);
            }

            // Supprimer tous les likes associés
            $post->likes()->delete();

            // Supprimer tous les commentaires associés
            $post->comments()->delete();

            // Décrémenter le compteur de posts de l'utilisateur
            if ($post->user) {
                $post->user->decrement('posts_count');
            }
        });

        // Après la création d'un post
        static::created(function ($post) {
            // Incrémenter le compteur de posts de l'utilisateur
            if ($post->user) {
                $post->user->increment('posts_count');
            }
        });
    }
}
