<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Post */
class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->whenHas('id'),
            'title' => $this->whenHas('title'),
            'created_at' => carbonate($this->created_at),
            'updated_at' => carbonate($this->updated_at),
            'body' => $this->whenHas('body'),
            'slug' => $this->whenHas('slug'),
            'can' => [
                'delete' => Auth::user()?->can('delete', $this->resource) ?? false
            ],
            'likes_count' => $this->whenHas('likes_count'),
            'liked' => $this->whenHas('liked'),
            'likes' => LikeResource::collection($this->whenLoaded('likes')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'topic' => TopicResource::make($this->whenLoaded('topic')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
