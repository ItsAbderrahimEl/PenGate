<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TopicSeeder::class
        ]);

        $users = User::factory(10)->create();

        Post::factory(60)
            ->withPostData()
            ->has(Comment::factory(10)->withCommentData()->recycle($users))
            ->recycle($users)
            ->create();

        User::factory()
            ->create([
                'name' => 'test test',
                'email' => 'test@gmail.com',
            ]);
    }
}
