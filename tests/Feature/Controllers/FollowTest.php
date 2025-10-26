<?php

use App\Models\Follow;
use App\Exceptions\FollowException;

//---------------------------------------------------------------------------------------
//Store

it('Should be authenticated before you can follow someone', function () {
    $this->post(route('follows.store', user()->id))->assertRedirectToRoute('login.create');
});

it('Validates that user really exists', function () {
    login()->post(route('follows.store', 200))->assertNotFound();
});

it('You cannot follow the same person two times', function () {
    $this->withoutExceptionHandling();

    $follower = user();
    $followed = user();

    login($follower)->post(route('follows.store', $followed->id));

    expect(
        fn() => $this->post(route('follows.store', $followed->id))
    )->toThrow(FollowException::class);
});

//---------------------------------------------------------------------------------------
//Destroy

it('Make sure you are authenticated before you can unfollow a user', function () {
    $this->delete(route('follows.destroy', user()->id))->assertRedirectToRoute('login.create');
});

it('Can unfollow a user', function () {
    login();

    $follow = Follow::factory()->create();

    $this->delete(route('follows.destroy', $follow->id));

    $this->assertDatabaseMissing($follow->getTable(), $follow->toArray());
});