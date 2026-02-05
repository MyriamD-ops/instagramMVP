<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'profile_picture',
        'website',
        'is_private',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_private' => 'boolean',
        ];
    }

    // ===== RELATIONS =====

    /**
     * Les posts de l'utilisateur
     */
    public function posts()
    {
        return $this->hasMany(Post::class)->latest();
    }

    /**
     * Les commentaires de l'utilisateur
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Les likes de l'utilisateur
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Les utilisateurs que cet utilisateur suit
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')
            ->withTimestamps();
    }

    /**
     * Les utilisateurs qui suivent cet utilisateur
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
            ->withTimestamps();
    }

    /**
     * Les conversations de l'utilisateur
     */
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_user')
            ->withPivot('last_read_at')
            ->withTimestamps();
    }

    /**
     * Les messages envoyés par l'utilisateur
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // ===== MÉTHODES UTILES =====

    /**
     * Vérifier si l'utilisateur suit un autre utilisateur
     */
    public function isFollowing(User $user)
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    /**
     * Vérifier si l'utilisateur est suivi par un autre utilisateur
     */
    public function isFollowedBy(User $user)
    {
        return $this->followers()->where('follower_id', $user->id)->exists();
    }

    /**
     * Suivre un utilisateur
     */
    public function follow(User $user)
    {
        if (!$this->isFollowing($user)) {
            $this->following()->attach($user->id);
            $this->increment('following_count');
            $user->increment('followers_count');
        }
    }

    /**
     * Ne plus suivre un utilisateur
     */
    public function unfollow(User $user)
    {
        if ($this->isFollowing($user)) {
            $this->following()->detach($user->id);
            $this->decrement('following_count');
            $user->decrement('followers_count');
        }
    }

    /**
     * Vérifier si l'utilisateur a liké un post
     */
    public function hasLiked(Post $post)
    {
        return $this->likes()->where('post_id', $post->id)->exists();
    }

    /**
     * Obtenir le feed de l'utilisateur (posts des personnes suivies)
     */
    public function feed()
    {
        $followingIds = $this->following()->pluck('users.id');
        
        return Post::whereIn('user_id', $followingIds)
            ->orWhere('user_id', $this->id)
            ->with(['user', 'likes', 'comments'])
            ->latest()
            ->paginate(15);
    }
}
