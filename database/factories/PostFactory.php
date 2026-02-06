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
        // Générer une image placeholder via service en ligne
        $width = 800;
        $height = rand(600, 1000);
        $randomId = rand(1, 1000);
        
        return [
            'user_id' => User::factory(),
            'caption' => fake()->optional(0.8)->paragraph(rand(1, 3)),
            'image_path' => "https://picsum.photos/seed/{$randomId}/{$width}/{$height}",
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
