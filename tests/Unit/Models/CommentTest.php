<?php

use App\Models\Comment;

beforeEach(function () {
    $this->comment = Comment::factory()->create();
});

it('Has a body', function () {
    expect($this->comment->body)->not()->toBeNull();
});

it('Has a likes_count', function () {
    expect(
        $this->comment->likes_count
    )->not()->toBeNull();
});



it('Belongs to a user', function () {
    expect($this->comment->user)->not()->toBeNull();
});

it('Belongs to a post', function () {
    expect($this->comment->post)->not()->toBeNull();
});

it('Can be liked', function () {
    $comment = Comment::factory()->hasLikes(2)->create();

    expect($comment->likes)->toHaveCount(2);
});

