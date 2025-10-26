<?php

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Follow;
use App\Models\Comment;

beforeEach(function () {
    $this->user = User::factory()->create([
        'name' => 'Oli sandi'
    ]);
});

it('Has name, email, password, avatar, phone number and a bio', function () {
    $attributes = [
        'name', 'email', 'password', 'avatar', 'phone', 'bio'
    ];
    foreach ($attributes as $attribute) {
        expect($this->user->{$attribute})->not()->toBeNull();
    }
});

it('Casts the email_verified_at and password', function () {
    expect($this->user->getCasts())
        ->toHaveKey('email_verified_at', 'datetime')
        ->toHaveKey('password', 'hashed');
});

it('Can have multiple posts', function () {
    Post::factory(3)->recycle($this->user)->create();
    expect($this->user->posts)->toHaveCount(3);
});

it('Can have multiple comments', function () {
    Comment::factory(3)->recycle($this->user)->create();
    expect($this->user->comments)->toHaveCount(3);
});

it('Can like multiple posts', function () {
    Like::factory(2)->recycle([
        Post::factory(2)->create(),
        $this->user
    ])->create();

    expect($this->user->likes)->toHaveCount(2);
});

it('Normalizes the user name', function () {
    expect(DB::table('users')->first())
        ->toHaveProperty('name_normalized', 'Olisandi');
});

it('Can have multiple followers', function () {
    Follow::factory(2)->create([
        'followed_id' => $this->user->id,
    ]);

    expect($this->user->followers)->toHaveCount(2);
});
