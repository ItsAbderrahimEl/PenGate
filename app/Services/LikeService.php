<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Comment;

class LikeService
{
    protected static array $likable_types = [
        'post' => Post::class,
        'comment' => Comment::class,
    ];

    public function get_likable($type, $id)
    {
        return static::$likable_types[$type]::findOrFail($id);
    }

    public function can_be_liked_this($type): static
    {
        abort_if(
            !in_array($type, array_keys(static::$likable_types)),
            404
        );

        return $this;
    }
}
