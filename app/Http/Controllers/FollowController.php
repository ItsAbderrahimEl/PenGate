<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use App\Models\Follow;
use App\Exceptions\FollowException;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /**
     * @throws Throwable
     */
    public function store(User $followed): void
    {
        throw_if(
            Follow::where('follower_id', Auth::id())
                ->where('followed_id', $followed->id)->exists(),
            FollowException::class
        );

        Follow::create([
            'follower_id' => Auth::id(),
            'followed_id' => $followed->id,
        ]);
    }

    public function destroy(Follow $follow): void
    {
        $follow->delete();
    }
}
