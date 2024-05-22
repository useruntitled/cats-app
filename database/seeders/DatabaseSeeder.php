<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $users = User::factory()
            ->count(5)
            ->has(Post::factory()
                ->count(2)
            )
            ->create();

        $postsIds = \DB::table('posts')->pluck('id')->all();
        $usersIds = \DB::table('users')->pluck('id')->all();

        foreach ($postsIds as $postId) {
            $comment = Comment::factory()
                ->state(new Sequence([
                    'user_id' => $usersIds[array_rand($usersIds)],
                    'post_id' => $postId,
                ]))
                ->create();
            Comment::factory()
                ->state(new Sequence([
                    'user_id' => $usersIds[array_rand($usersIds)],
                    'post_id' => $postId,
                    'comment_id' => $comment->id,
                    'reply_id' => $comment->id,
                ]))
                ->create();
        }

    }
}
