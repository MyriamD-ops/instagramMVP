<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->when($this->id === auth()->id(), $this->email),
            'bio' => $this->bio,
            'website' => $this->website,
            'profile_picture' => $this->profile_picture 
                ? asset('storage/' . $this->profile_picture)
                : null,
            'is_private' => $this->is_private,
            'followers_count' => $this->followers_count,
            'following_count' => $this->following_count,
            'posts_count' => $this->posts_count,
            'is_following' => $this->when(
                auth()->check(),
                fn() => auth()->user()->isFollowing($this->resource)
            ),
            'is_followed_by' => $this->when(
                auth()->check(),
                fn() => auth()->user()->isFollowedBy($this->resource)
            ),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
