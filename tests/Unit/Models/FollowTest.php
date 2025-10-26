<?php

use App\Models\User;
use App\Models\Follow;

beforeEach(function () {
    $this->follow = Follow::factory()->create();
});

it('Has the followed_id and the follower_id attributes', function () {
    $attributes = [
        'followed_id', 'follower_id'
    ];

    foreach ($attributes as $attribute) {
        expect($this->follow->{$attribute})->not()->toBeNull();
    }
});

it('Has a follower user', function () {
    expect($this->follow->follower)
        ->not()->toBeNull()
        ->toBeInstanceOf(User::class);
});

it('Has a followed user', function () {
    expect($this->follow->followed)
        ->not()->toBeNull()
        ->toBeInstanceOf(User::class);
});