<?php

use App\Models\Post;
use App\Models\Topic;
use App\Models\Comment;

beforeEach(function () {
    $this->post = Post::factory()->create(['title' => 'test title', 'body' => 'Test body']);
});

it('Belongs to a user', function () {
    expect($this->post->user)->not()->toBeNull();
});

it('Belongs to a topic', function () {
    expect(
        $this->post->topic
    )->toBeInstanceOf(Topic::class);
});

it('Has a title and a body', function () {
    expect(
        $this->post->title
    )->not()->toBeNull()
        ->and(
            $this->post->body
        )->not()->toBeNull();
});

it('Has the likes_count column', function () {
    expect($this->post->likes_count)->not()->toBeNull();
});

it('Can have multiples comments', function () {
    Comment::factory(3)->recycle($this->post)->create();

    expect($this->post->comments)->toHaveCount(3);
});

it('Converts the title to title case', function () {
    expect($this->post->title)->toBe('Test Title');
});

it('Can be liked', function () {
    $post = Post::factory()->hasLikes(2)->create();

    expect($post->likes)->toHaveCount(2);
});