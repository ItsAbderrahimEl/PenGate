<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Http\Resources\CommentResource;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->post = Post::factory()->create();

    $this->comment = Comment::factory()
        ->recycle($this->user)
        ->recycle($this->post)
        ->create();
});

//---------------------------------------------------------------------------------------
//Store
it('Verifies the rate limiting to post a comment', function () {
    RateLimiter::increment('posts.comments.store|127.0.0.1', amount: 8);

    login()->post(route('posts.comments.store', $this->post))
        ->assertSessionHas('flash.banner', 'Too many attempts. Please try again later.');
});

it('Require authentication to post a comment', function () {
    $this->post(route('posts.comments.store', $this->post->id))
        ->assertRedirect(route('login.create'));
});

it('Can validate the create comment form', function () {
    login($this->user)
        ->post(route('posts.comments.store', $this->post->id), [
            'body' => NULL
        ])->assertSessionHasErrors('body');
});

it('Can create a comment', function () {
    login($this->user)
        ->post(route('posts.comments.store', $this->post->id), [
            'body' => 'test comment'
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    $this->assertDatabaseHas(Comment::class, [
        'post_id' => $this->post->id,
        'user_id' => $this->user->id,
        'body' => 'test comment'
    ]);
});

//---------------------------------------------------------------------------------------
//Update
it('can redirect if the user is not authenticated', function () {
    $this->put(route('comments.update', $this->comment->id))
        ->assertRedirectToRoute('login.create');
});

it('allows only the owner to update his comment', function () {
    login()->put(route('comments.update', $this->comment->id))
        ->assertForbidden();
});

it('Verifies the rate limiting to update a comment', function () {
    RateLimiter::increment('comments.update|127.0.0.1', amount: 8);

    login()->put(route('comments.update', $this->comment))
        ->assertSessionHas('flash.banner', 'Too many attempts. Please try again later.');
});

it('passes the authorization of updating to the frontend', function () {
    login($this->user);
    expect(CommentResource::make($this->comment)->response()->getData()->can->update)
        ->toBeTrue();

    login(user());
    expect(CommentResource::make($this->comment)->response()->getData()->can->update)
        ->toBeFalse();
});

it('validates the comment data', function () {
    login($this->user)
        ->put(route('comments.update', $this->comment->id), [
            'body' => 111
        ])->assertSessionHasErrors(['body']);
});

it('updates a comment', function () {
    login($this->user)
        ->put(route('comments.update', $this->comment->id), [
            'body' => 'test comment'
        ]);

    $this->assertDatabaseHas(Comment::class, [
        'body' => 'test comment'
    ]);
});

//---------------------------------------------------------------------------------------
//Destroy
it("Passes the authorization of deleting to the frontend", function () {
    login($this->user);
    expect(CommentResource::make($this->comment)->response()->getData()->can->delete)
        ->toBeTrue();

    login(user());
    expect(CommentResource::make($this->comment)->response()->getData()->can->delete)
        ->toBeFalse();
});

it('Do not allow the delete of a comment if an hour has passed', function () {
    $this->travel(1)->hour();

    login($this->user)
        ->delete(route('comments.destroy', $this->comment->id))
        ->assertForbidden();
});

it('Require authentication to delete a comment', function () {
    $this->delete(route('comments.destroy', $this->comment->id))
        ->assertRedirectToRoute('login.create');
});

it("requires to be the owner of the comment to delete it", function () {
    login(user())->delete(route('comments.destroy', $this->comment->id))
        ->assertStatus(403);
});

it('Deletes a comment', function () {
    login($this->user)
        ->delete(route('comments.destroy', $this->comment->id))
        ->assertRedirect();

    $this->assertModelMissing($this->comment);
    $this->assertModelExists($this->post);
});
