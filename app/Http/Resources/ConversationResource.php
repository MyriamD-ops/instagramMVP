<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $user = auth()->user();

        return [
            'id' => $this->id,
            'participants' => UserResource::collection($this->whenLoaded('participants')),
            'other_participant' => new UserResource($this->whenLoaded('participants', function() use ($user) {
                return $this->otherParticipant($user);
            })),
            'last_message' => new MessageResource($this->whenLoaded('lastMessage')),
            'unread_count' => $this->when(
                $user && $this->relationLoaded('participants'),
                fn() => $this->unreadCount($user)
            ),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
