<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'caption' => fake()->optional()->sentence(15),
            'image_path' => 'posts/default.jpg', // Chemin par défaut, à remplacer par une vraie image en production
            'likes_count' => 0,
            'comments_count' => 0,
        ];
    }

    /**
     * Indicate that the post has a specific number of likes
     */
    public function withLikes(int $count): static
    {
        return $this->state(fn (array $attributes) => [
            'likes_count' => $count,
        ]);
    }

    /**
     * Indicate that the post has a specific number of comments
     */
    public function withComments(int $count): static
    {
        return $this->state(fn (array $attributes) => [
            'comments_count' => $count,
        ]);
    }
}
