<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    private static Collection $data;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'topic_id' => function () {
                $topic = Topic::inRandomOrder()->first();

                return $topic ? $topic->id : Topic::factory()->create()->id;
            },
            'title' => 'title',
            'body' => 'body',
            'likes_count' => 0,
        ];
    }

    public function withPostData(int $limit = NULL): PostFactory
    {
        return $this->sequence(...
            $this->getData($limit)
                ->map(fn($content) => $this->parsePostContent($content))
                ->map(fn($parts) => $this->extractTitleAndBody($parts)));
    }

    private static function getData(int $limit = NULL): Collection
    {
        return static::$data ??= collect(
            File::files(base_path("database/data/posts"))
        )->shuffle()->take($limit)->map(fn($file) => File::get($file->getPathname()));
    }

    private function parsePostContent(string $content): array
    {
        return explode("\n", $content, 2);
    }

    private function extractTitleAndBody(array $parts): array
    {
        return [
            'title' => str(Arr::first($parts))->remove(['<h1>', '</h1>'])->trim(),
            'body' => str(Arr::last($parts))->trim()
        ];
    }
}
