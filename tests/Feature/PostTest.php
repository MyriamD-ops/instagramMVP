<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_create_post()
    {
        Storage::fake('public');
        
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('photo.jpg');

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/posts', [
                'image' => $file,
                'caption' => 'Test post caption',
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'caption',
                'image_path',
                'user'
            ]);

        $this->assertDatabaseHas('posts', [
            'user_id' => $user->id,
            'caption' => 'Test post caption',
        ]);

        Storage::disk('public')->assertExists('posts/' . $file->hashName());
    }

    /** @test */
    public function user_can_view_feed()
    {
        $user = User::factory()->create();
        $followedUser = User::factory()->create();
        
        $user->follow($followedUser);
        
        Post::factory()->create(['user_id' => $followedUser->id]);
        Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/feed');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'caption',
                        'image_path',
                        'user'
                    ]
                ]
            ]);
    }

    /** @test */
    public function user_can_delete_their_own_post()
    {
        Storage::fake('public');
        
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(200);
        
        $this->assertSoftDeleted('posts', [
            'id' => $post->id,
        ]);
    }

    /** @test */
    public function user_cannot_delete_another_users_post()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(403);
        
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
        ]);
    }

    /** @test */
    public function user_can_like_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson("/api/posts/{$post->id}/like");

        $response->assertStatus(200)
            ->assertJson([
                'liked' => true,
            ]);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }

    /** @test */
    public function user_can_unlike_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        
        // Premier like
        $post->like($user);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson("/api/posts/{$post->id}/like");

        $response->assertStatus(200)
            ->assertJson([
                'liked' => false,
            ]);

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }
}
