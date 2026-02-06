<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un utilisateur de test
        $testUser = User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'bio' => 'Photographe passionné 📸',
            'website' => 'https://johndoe.com',
        ]);

        // Créer d'autres utilisateurs
        $users = User::factory(10)->create();

        // Chaque utilisateur crée des posts
        $allUsers = $users->push($testUser);
        
        foreach ($allUsers as $user) {
            // Créer 3-5 posts par utilisateur
            $posts = Post::factory(rand(3, 5))->create([
                'user_id' => $user->id,
            ]);

            foreach ($posts as $post) {
                // Des utilisateurs aléatoires likent les posts
                $likers = $allUsers->random(rand(0, 8));
                foreach ($likers as $liker) {
                    if ($liker->id !== $post->user_id) {
                        Like::create([
                            'user_id' => $liker->id,
                            'post_id' => $post->id,
                        ]);
                        $post->increment('likes_count');
                    }
                }

                // Des utilisateurs aléatoires commentent les posts
                $commenters = $allUsers->random(rand(0, 5));
                foreach ($commenters as $commenter) {
                    Comment::factory()->create([
                        'user_id' => $commenter->id,
                        'post_id' => $post->id,
                    ]);
                    $post->increment('comments_count');
                }
            }
        }

        // Créer des relations de follow aléatoires
        foreach ($allUsers as $user) {
            $usersToFollow = $allUsers
                ->where('id', '!=', $user->id)
                ->random(rand(2, 6));

            foreach ($usersToFollow as $userToFollow) {
                $user->follow($userToFollow);
            }
        }

        $this->command->info('Base de données peuplée avec succès !');
    }
}
