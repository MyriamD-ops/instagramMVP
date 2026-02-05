<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'content',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // ===== RELATIONS =====

    /**
     * L'utilisateur qui a commenté
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Le post commenté
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
