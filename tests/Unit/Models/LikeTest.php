<?php

use App\Models\{Like, User};

beforeEach(function () {
    $this->like = Like::factory()->create();
});

it('Has the likeable morph columns', function () {
    expect(
        $this->like->likeable_type
    )->not()->toBeNull()
        ->and(
            $this->like->likeable_id
        )->not()->toBeNull();
});

it('belongs to a user ', function () {
    expect(
        $this->like->owner_id
    )->not()->toBeNull()
        ->and(
            $this->like->owner
        )->toBeInstanceOf(User::class);
});

it('Uses post and comment for the type', function () {
    expect($this->like->likeable_type)->toBeIn(['post', 'comment']);
});