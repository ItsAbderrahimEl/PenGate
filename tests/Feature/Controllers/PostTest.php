<?php

use App\Models\Post;
use App\Models\Like;
use App\Models\User;
use App\Models\Topic;
use App\Models\Comment;
use Illuminate\Support\Arr;
use App\Notifications\PostCreated;
use Illuminate\Support\Facades\DB;
use Inertia\Testing\AssertableInertia;
use App\Http\Resources\CommentResource;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    $this->user = user();

    $this->post = Post::factory()
        ->recycle($this->user)
        ->create(['title' => 'Title test']);

    $this->topic = fn() => Topic::factory()->create();
});

//---------------------------------------------------------------------------------------
//Index

it('Returns the posts page paginated', function () {
    $this->get(route('posts.index'))
        ->assertComponentIs('Post/Index')
        ->assertHasKey('posts');
});

it('Returns the topics', function () {
    $this->get(route('posts.index'))->assertHasKey('topics');
});

it('Includes the topic with each post', function () {
    $this->get(route('posts.index'))->assertInertia(function (AssertableInertia $page) {
        $post = Arr::first($page->getProp('posts.data'));

        expect(
            Arr::has($post, 'topic')
        )->toBeTrue()
            ->and(
                Arr::has($post['topic'], ['id', 'name'])
            )->toBeTrue();
    });
});

it("Returns not found if the topic don't exists", function () {
    $this->get(route('posts.index', ['topic' => 'abs']))
        ->assertNotFound();
});

it('Can filter the posts by topic', function () {
    Topic::factory(3)->create();
    Post::factory(3)->create();

    $this->get(route('posts.index', ['topic' => $this->post->topic->name]))
        ->assertInertia(function (AssertableInertia $page) {
            expect(
                Arr::get($page->getProp('posts.data.0'), 'topic.name')
            )->toEqual(
                $this->post->topic->name
            );
        });
});

it('Can filter the posts by title', function () {
    Post::factory()->create();
    $post = Post::factory()->create([
        'title' => 'Special Post'
    ]);

    $this->get(route('posts.index', ['title' => $post->title]))
        ->assertInertia(function (AssertableInertia $page) {
            expect(
                $page->getProp('posts.data.0.title')
            )->toEqual('Special Post');
        });
});

//---------------------------------------------------------------------------------------
//Store
it('Requires authentication to store a post', function () {
    $this->post(
        route('posts.store')
    )->assertRedirectToRoute('login.create');
});

it('Verifies the rate limiting to create a post', function () {
    RateLimiter::increment('posts.store|127.0.0.1', amount: 8);

    login()->post(
        route('posts.store')
    )->assertSessionHas('flash.banner', 'Too many attempts. Please try again later.');
});

it('It validates the create post form', function () {
    login()->post(route('posts.store'), [
        'title' => '',
        'body' => '',
        'topic_id' => NULL
    ])->assertSessionHasErrors(['title', 'body', 'topic_id']);
});

it('Create a post', function () {
    $response = login()->post(route('posts.store'), [
        'title' => 'Nice and Cool',
        'body' => 'The post is amazing hahaha',
        'topic_id' => call_user_func($this->topic)->id
    ]);

    $post = Post::latest('id')->first();

    $response->assertSessionHasNoErrors()
        ->assertRedirectToRoute('posts.show', $post->id)
        ->assertSessionHas('flash.banner', 'Post Created.');

    $this->assertDatabaseHas(Post::class, $post->toArray());
});

it("Sends a notification to all followers of the post's author to inform them about the new post", function () {
    $user =User::factory()->hasFollowers(2)->create();

    $response = login($user)->post(route('posts.store'), [
        'title' => 'Post notification test',
        'body' => 'The post is amazing hahaha',
        'topic_id' => call_user_func($this->topic)->id
    ]);

    expect(DB::table('notifications')->count())->toBe(2);
});

//---------------------------------------------------------------------------------------
//Show
it('Can show a single post', function () {
    $this->post->load(['user', 'topic']);

    $this->get(route('posts.show', [$this->post->id, $this->post->slug]))
        ->assertComponentIs('Post/Show')
        ->assertHasKey('post');
});

it('Can show the comments of the post', function () {
    $post = Post::factory()
        ->withPostData(1)
        ->hasComments(2)
        ->create();

    $this->get(route('posts.show', [$post->id, $post->slug]))
        ->assertComponentIs('Post/Show')
        ->assertHasPaginatedResource(
            'comments',
            CommentResource::collection($post->comments()->with('user')->paginate(10))
        );
});

it("Redirect to the url with the slug if the slug it's not included or is incorrect", function () {
    login()->get(route('posts.show', $this->post->id))
        ->assertRedirect("/posts/{$this->post->id}/{$this->post->slug}");
});

it('Loads the topic whit the post', function () {
    $this->get(route('posts.show', [$this->post->id, $this->post->slug]))
        ->assertInertia(function (AssertableInertia $page) {
            expect(Arr::has($page->getProp('post'), 'topic'))->toBeTrue();
        });
});

it("Includes the like of the current user and returns false if not", function () {
    $like = Like::factory()
        ->recycle($this->user)
        ->for($this->post, 'likeable')
        ->create();

    //Has been liked by the user
    login($this->user)
        ->get(route('posts.show', [$this->post->id, $this->post->slug]))
        ->assertInertia(function (AssertableInertia $page) use ($like) {
            expect(
                $page->getProp('post.liked')
            )->toEqual($like->id);
        });

    //Has not
    login()
        ->get(route('posts.show', [$this->post->id, $this->post->slug]))
        ->assertInertia(function (AssertableInertia $page) use ($like) {
            expect(
                $page->getProp('post.liked')
            )->toBeFalse();
        });
});

it('Includes with each comment of the post the liked property', function () {
    $comment = Comment::factory()
        ->recycle([$this->user, $this->post])
        ->hasLikes()
        ->create();

    login($this->user)->get(route('posts.show', [$this->post->id, $this->post->slug]))
        ->assertInertia(function (AssertableInertia $page) use ($comment) {
            [$first_comment] = Arr::first($page->getProp('comments'));

            expect($first_comment)
                ->toHaveKey('liked')
                ->and($first_comment['liked'])
                ->toEqual($comment->likes->first()->id);;
        });
});

//---------------------------------------------------------------------------------------
//Destroy
it('Requires authentication to delete a post', function () {
    $this->delete(route('posts.destroy', 1))->assertRedirectToRoute('login.create');
});

it('Requires to be the owner of the post to delete it', function () {
    login(user())->delete(route('posts.destroy', $this->post->id))->assertForbidden();
});

it('An authorized user can delete his posts ', function () {
    login($this->user)
        ->delete(route('posts.destroy', $this->post->id))
        ->assertRedirectToRoute('posts.index');

    $this->assertModelMissing($this->post);
});
