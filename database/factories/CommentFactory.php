<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public static Collection $data;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'post_id' => Post::factory(),
            'likes_count' => 0,
            'body' => '',
        ];
    }

    public function withCommentData(int $limit = NULL): CommentFactory
    {
        return $this->sequence(...$this->getData($limit)
            ->map(fn($body) => $this->getBody($body)));
    }

    private static function getData(int $limit = NULL): Collection
    {
        return static::$data ??= collect(
            File::files(base_path("database/data/comments"))
        )->shuffle()->take($limit)->map(fn($file) => File::get($file->getPathname()));
    }

    private function getBody(string $body): array
    {
        return [
            'body' => $body
        ];
    }
}
