<?php

namespace App\Models;

use App\Traits\HasAvatar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasAvatar;

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::updated(function (User $user) {
            when($user->isDirty('email'), function () use ($user) {
                $user->updateQuietly([
                    'email_verified_at' => NULL,
                ]);
                $user->sendEmailVerificationNotification();
            });
        });
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }

    public function follows(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, foreignKey: 'owner_id');
    }

    public function liked_posts(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'likeable', 'likes', 'owner_id', 'likeable_id');
    }

    public function is_followed_by_current_user(): static
    {
        if (Auth::check()) {
            $this->setAttribute(
                'is_followed_by_current_user',
                $this->followers()->where('follower_id', Auth::id())->value('follower_id') ?? false
            );
        }

        return $this;
    }
}
