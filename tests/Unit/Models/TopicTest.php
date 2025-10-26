<?php

use App\Models\Post;
use App\Models\Topic;
use App\Http\Resources\TopicResource;

beforeEach(function () {
    $this->topic = Topic::factory()
        ->has(
            Post::factory(3)
        )->create();
});

it('Has the name column', function () {
    expect(
        is_string($this->topic->name)
    )->toBeTrue();
});

it('Has many posts', function () {
    expect(
        $this->topic->posts->count()
    )->toEqual(3);
});

it('It includes the name in the topic resources', function () {
    expect(
        TopicResource::make($this->topic)->response()->getData()->name
    )->toEqual($this->topic->name);
});

it("Don't includes the posts in the topic if not loaded using the resource", function () {
    expect(
        Arr::exists(
            (array) TopicResource::make($this->topic)->response()->getData(),
            'posts'
        )
    )->toBeFalse();
});

it("Includes the posts in the topic if loaded using the resource", function () {
    $this->topic->load('posts');

    expect(
        Arr::has(
            (array) TopicResource::make($this->topic)->response()->getData(),
            'posts'
        )
    )->toBeTrue();
});

