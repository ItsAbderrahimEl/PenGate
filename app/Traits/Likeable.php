<?php

namespace App\Traits;

use App\Models\Like;
use App\Exceptions\LikeException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Likeable
{
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function is_not_liked(): static
    {
        throw_if(
            Like::where('owner_id', Auth::id())
                ->where('likeable_type', $this->getMorphClass())
                ->where('likeable_id', $this->id)
                ->exists(),
            LikeException::class
        );

        return $this;
    }

    public function is_liked_by($user = NULL): static
    {
        if ($user && Auth::check()) {
            $this->setAttribute(
                'liked',
                $this->likes()->whereBelongsTo($user, 'owner')->value('id') ?? false
            );
        }

        return $this;
    }

    public function like_it(): void
    {
        $this->likes()->create([
            'owner_id' => Auth::id()
        ]);
    }
}
