<?php

it('Returns a 404 if the type is not in the Enum', function () {
    login()->get(route('example', 'movie'))->assertNotFound();
});

it('Can return an example of comment', function () {
    $response = login()->get(route('example', 'Comment'))
        ->assertStatus(200);

    expect(
        is_string($response->content())
    )->toBeTrue();
});

it('Can return an example of post', function () {
    $response = login()->get(route('example', 'Post'))
        ->assertStatus(200);

    expect(
        is_string($response->content())
    )->toBeTrue();
});
