<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\{Post, Topic};
use App\Notifications\PostCreated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\{PostResource, TopicResource, CommentResource};
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Post/Index', [
            'posts' => fn() => PostResource::collection(
                Post::query()
                    ->withoutBody()
                    ->searchByTopic()
                    ->searchByTitle()
                    ->with([
                        'topic',
                        'user:id,name,name_normalized'
                    ])
                    ->latest()
                    ->paginate(15)

            ),
            'topics' => fn() => TopicResource::collection(Topic::all())
        ]);
    }

    public function show(Post $post): Response|RedirectResponse
    {
        if ($this->doesnt_include_the_slug($post)) {
            return Redirect::route('posts.show', [$post->id, $post->slug]);
        }

        $user = Auth::user();

        return Inertia::render('Post/Show', [
            'post' => fn() => PostResource::make(
                $post->load(['topic', 'user:id,name'])
                    ->is_liked_by($user)
            ),
            'comments' => fn() => CommentResource::collection(
                $post->comments()
                    ->with('user')
                    ->latest()
                    ->paginate(7)
                    ->through(fn($comment) => $comment->is_liked_by($user))
            )
        ]);
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $post = Post::create([
            ...$request->validated(),
            'user_id' => Auth::id(),
        ]);

        Notification::send(
            Auth::user()->followers,
            new PostCreated($post->load(['user', 'topic']))
        );

        return Redirect::route('posts.show', $post->id)->banner('Post Created.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        $post->delete();

        return Redirect::route('posts.index');
    }

    private function doesnt_include_the_slug($post): bool
    {
        return request()->route('slug') !== $post->slug;
    }
}
