<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\{Auth, Redirect};
use Illuminate\Container\Attributes\CurrentUser;
use App\Http\Resources\{UserResource, PostResource};
use App\Http\Requests\{RegisterUserRequest, UpdateProfileRequest};

class UserController extends Controller
{
    public function __construct(
        #[CurrentUser] private readonly User $user,
    ) {}

    public function create(): Response
    {
        return Inertia::render('Auth/Signup');
    }

    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());

        session()->regenerate(true);

        Auth::login($user);

        event(new Registered($user));

        return redirect()->route('verification.notice');
    }

    public function show(User $user): Response
    {
        return Inertia::render('User/Show', [
            'user' => fn() => UserResource::make(
                $user->is_followed_by_current_user()
            ),
            'liked_posts' => fn() => PostResource::collection(
                $user->liked_posts()
                    ->with(['topic', 'user'])
                    ->latest()
                    ->select([
                        'posts.id', 'posts.likes_count',
                        'posts.title', 'posts.created_at',
                        'posts.topic_id', 'posts.user_id'
                    ])->get()
            ),
            'authored_posts' => fn() => PostResource::collection(
                $user->posts()
                    ->with('topic')
                    ->latest()
                    ->select([
                        'posts.id', 'posts.likes_count',
                        'posts.title', 'posts.created_at',
                        'posts.topic_id'
                    ])->get()
            )
        ]);
    }

    public function edit(): Response
    {
        return Inertia::render('User/Profile');
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        if ($request->has('password')) {
            $this->user->update($request->only('password'));

            return Redirect::back()->banner('Your password has been updated.');
        }

        $this->user->update($request->safe(['name', 'email']));

        $this->user->storeNewAvatar($request->validated('avatar'));

        return Redirect::back()->banner('Profile updated successfully.');
    }

    public function destroy(): RedirectResponse
    {
        $this->user->delete();

        return Redirect::route('login.create')->banner('User successfully deleted.');
    }
}
