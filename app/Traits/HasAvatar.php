<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

trait HasAvatar
{
    public static function storeNewAvatar($profilePhoto): void
    {
        if ($profilePhoto === NULL) return;

        static::removePreviousAvatar();

        Auth::user()->update([
                'avatar' => Storage::disk('public')->putFile('avatars', $profilePhoto)
            ]
        );
    }

    protected static function removePreviousAvatar(): void
    {
        $avatar = Auth::user()->avatar;
        when(
            $avatar !== 'avatars/default.png',
            fn() => Storage::disk('public')->delete($avatar)
        );
    }
}
