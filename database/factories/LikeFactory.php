<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    public function definition(): array
    {
        $likeable = $this->faker->randomElement([
            Post::factory()->create(),
            Comment::factory()->create(),
        ]);

        return [
            'owner_id' => User::factory(),
            'likeable_type' => $likeable->getMorphClass(),
            'likeable_id' => $likeable->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
