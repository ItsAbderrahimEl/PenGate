<?php

use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Exceptions\LikeException;

it('Deny access to unauthenticated users', function () {
    $this->post(route('likes.store', ['post', 1]))->assertRedirectToRoute('login.create');
    $this->delete(route('likes.destroy', 1))->assertRedirectToRoute('login.create');
});

it('it aborts if the type passed is other than a comment or a post', function () {
    login()->post(route('likes.store', ['error', 1]))->assertNotFound();
});

it('Allows just the owner of the like to unlike it', function () {
    $like = Like::factory()
        ->for(Post::factory()->create(), 'likeable')
        ->create();

    login()->delete(route('likes.destroy', $like->id))->assertForbidden();
});

it('Makes sure a likeable can be liked just once', function () {
    $this->withoutExceptionHandling();

    $user = user();
    $post = Post::factory()->create();

    login($user)->post(route('likes.store', ['post', $post->id]));

    expect($post->refresh()->likes_count)->toBe(1)
        ->and(
            fn() => login($user)->post(route('likes.store', ['post', $post->id]))
        )->toThrow(LikeException::class);
});

describe('with likeable', function () {
    it('allows a likeable entity to be liked and increments its likes_count', function ($type, $likeableFactory) {
        $this->withoutExceptionHandling();
        $likeable = $likeableFactory();

        expect($likeable->likes_count)->toBe(0);

        login()->post(route('likes.store', [$type, $likeable->id]));

        $this->assertDatabaseHas(Like::class, [
            'owner_id' => Auth::id(),
            'likeable_id' => $likeable->id,
            'likeable_type' => $type
        ]);

        expect($likeable->refresh()->likes_count)->toBe(1)
            ->and($likeable->likes)->toHaveCount(1);
    });

    it("Allows a likeable to be unliked and decrement it's likes_count", function ($type, $likeableFactory) {
        $likeable = $likeableFactory();
        $user = user();

        $like = Like::factory()
            ->for($likeable, 'likeable')
            ->recycle($user)
            ->create();

        login($user)->delete(route('likes.destroy', $like->id));

        $this->assertDatabaseMissing('likes', $like->toArray());

        expect($likeable->refresh()->likes_count)->toBe(0)
            ->and($likeable->likes)->toHaveCount(0);
    });
})->with([
    ['post', fn() => Post::factory()->create()],
    ['comment', fn() => Comment::factory()->create()],
]);
