<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->whenHas('id'),
            'name' => $this->whenHas('name'),
            'name_normalized' => $this->whenHas('name_normalized'),
            'avatar' => $this->whenHas('avatar', "/storage/{$this->avatar}"),
            'is_followed_by_current_user' => $this->whenHas('is_followed_by_current_user'),
            $this->mergeWhen(
                $request->routeIs('users.show') || Auth::id() === $this->id, [
                    'bio' => $this->whenHas('bio'),
                    'email' => $this->whenHas('email'),
                    'phone' => $this->whenHas('phone')
                ]
            )
        ];
    }
}
