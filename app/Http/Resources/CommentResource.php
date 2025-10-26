<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Comment */
class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->whenHas('id'),
            'body' => $this->whenHas('body'),
            'created_at' => carbonate($this->created_at),
            'updated_at' => carbonate($this->updated_at),
            'post' => PostResource::make($this->whenLoaded('post')),
            'likes_count' => $this->whenHas('likes_count'),
            'liked' => $this->whenHas('liked'),
            'can' => [
                'update' => Auth::user()?->can('update', $this->resource) ?? false,
                'delete' => Auth::user()?->can('delete', $this->resource) ?? false
            ],
            'user' => UserResource::make($this->whenLoaded('user')),
            'likes' => LikeResource::collection($this->whenLoaded('likes')),
        ];
    }
}