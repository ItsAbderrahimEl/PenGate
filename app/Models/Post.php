<?php

namespace App\Models;

use App\Traits\Likeable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\{Model, Casts\Attribute, Relations\HasMany, Relations\BelongsTo, Factories\HasFactory};

class Post extends Model
{
    use HasFactory, Likeable;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function title(): Attribute
    {
        return Attribute::set(fn($value) => Str::title($value));
    }

    protected function slug(): Attribute
    {
        return Attribute::get(fn() => Str::slug($this->title));
    }

    public function scopeWithoutBody($query)
    {
        return $query->select('id', 'title', 'created_at', 'user_id', 'topic_id');
    }

    public function scopeSearchByTopic($query)
    {
        return $query->when(
            request('topic'),
            fn($query) => $query->where('topic_id', Topic::where('name', request('topic'))->valueOrFail('id')
            ));
    }

    public function scopeSearchByTitle($query)
    {
        return $query->when(
            request('title'),
            fn($query) => $query->where('title', 'like', '%'.Str::title(request('title')).'%')
        );
    }
}
