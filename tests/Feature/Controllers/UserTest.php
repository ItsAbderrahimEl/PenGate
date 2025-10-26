<?php

use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia;
use Illuminate\Auth\Events\Registered;

beforeEach(function () {
    user();
    $this->user = User::first();
});

//---------------------------------------------------------------------------------------
//Create
it('Returns the register page', function () {
    $this->get(route('signup.create'))
        ->assertComponentIs('Auth/Signup')
        ->assertStatus(200);
});

it('Redirects to the dashboard if authenticated', function () {
    login($this->user)->get(route('signup.create'))
        ->assertRedirect(route('posts.index'));
});

//---------------------------------------------------------------------------------------
//Store

it('Limits the number of register requests', function () {
    RateLimiter::increment('signup.store|127.0.0.1', amount: 8);

    $response = $this->post(route('signup.store'));

    $response->assertSessionHas([
        'flash.banner' => 'Too many attempts. Please try again later.',
    ]);
});

it('Validates the register form', function () {
    $this->post(route('signup.store'), [
        'name' => 'incorrectName415',
        'email' => 'incorrectEmail',
        'password' => 'nice',
    ])->assertSessionHasErrors([
        'email',
        'password',
        'name' => 'The name must contain only letters, and include your full name.'
    ]);
});

it('Register a user', function () {
    $data = [
        'name' => 'test testlala',
        'email' => 'testlol@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    Event::fake();

    $this->post(route('signup.store'), $data)
        ->assertRedirect(route('verification.notice'));

    $this->assertDatabaseHas(
        User::class,
        Arr::except($data, [
            'password_confirmation', 'password'
        ])
    );
    $this->assertAuthenticated();
    Event::assertDispatched(Registered::class);
});

//---------------------------------------------------------------------------------------
//edit
it('Redirects to the login page if not authenticated', function () {
    $this->get(route('profile.edit'))
        ->assertRedirectToRoute('login.create');
});

it('Returns the profile page', function () {
    login($this->user)
        ->get(route('profile.edit'))
        ->assertComponentIs('User/Profile');
});

//---------------------------------------------------------------------------------------
//update
it('Validate the name field', function () {
    login($this->user)
        ->post(route('profile.update'), [
            'name' => '12254',
        ])->assertSessionHasErrors('name');
});

it('Updates the name', function () {
    login($this->user)
        ->post(route('profile.update'), [
            'name' => 'Hello friend',
        ])->assertSessionHas('flash.banner', 'Profile updated successfully.');

    $this->assertDatabaseHas(User::class, [
        'name' => 'Hello friend'
    ]);
});

it('Validates the update password form', function () {
    login($this->user);

    $this->post(route('profile.update'), [
        'current_password' => 'password',
        'new_password' => '123910',
        'new_password_confirmation' => '12345678910',
    ])->assertSessionHasErrors('new_password', 'The passwords do not match.');

    $this->post(route('profile.update'), [
        'current_password' => 'incorrectPassword',
    ])->assertSessionHasErrors('current_password', 'The current password is incorrect.');
});

it('Updates the password', function () {
    $ancient_password = $this->user->password;

    login($this->user)
        ->post(route('profile.update'), [
            'current_password' => 'password',
            'new_password' => '12345678910',
            'new_password_confirmation' => '12345678910',
        ])->assertSessionHas('flash.banner', 'Your password has been updated.');

    $new_password = $this->user->fresh()->password;
    $this->assertNotEquals($ancient_password, $new_password);
});

it('Validates the email input', function () {
    login($this->user)
        ->post(route('profile.update'), [
            'email' => '@test.com',
        ])->assertSessionHasErrors(['email' => 'The email field must be a valid email address.']);
});

it('Updates the email', function () {
    $this->withoutExceptionHandling();
    login($this->user)
        ->post(route('profile.update'), [
            'email' => 'changedEmail@example.com',
        ])->assertSessionHas('flash.banner', 'Profile updated successfully.');

    expect($this->user->email)->toBe('changedEmail@example.com');
});

it('updates the name and the email at the same time', function () {
    login($this->user)
        ->post(route('profile.update'), [
            'name' => 'Hello friend',
            'email' => 'changedEmail@example.com',
        ])
        ->assertSessionDoesntHaveErrors()
        ->assertSessionHas(['flash.banner' => 'Profile updated successfully.']);

    $this->assertDatabaseHas(User::class, [
        'name' => 'Hello friend',
        'email' => 'changedEmail@example.com'
    ]);
});

it('updates the avatar photo and deletes the previous one', function () {
    Storage::fake('public');

    // Create fake previous and new photos
    $previousPhoto = UploadedFile::fake()->image('avatar.png');
    $newPhoto = UploadedFile::fake()->image('avatar2.png');

    $previousPath = Storage::disk('public')->put('avatars', $previousPhoto);
    $this->user->update(['avatar' => $previousPath]);

    expect(Storage::disk('public')->fileExists($previousPath))->toBeTrue();

    login($this->user)->post(route('profile.update'), [
        'avatar' => $newPhoto,
    ]);

    $newPath = "avatars/{$newPhoto->hashName()}";

    expect(Storage::disk('public')->fileExists($newPath))->toBeTrue()
        ->and(Storage::disk('public')->fileExists($previousPath))->toBeFalse();
});

it('Deletes the session of the user', function () {
    $sessionId = session()->getId();

    login($this->user)
        ->delete(route('sessions.destroy'), [
            'password' => 'password'
        ])
        ->assertSessionHas('flash.banner', 'Logged out from all devices, except this one.');

    expect($sessionId)->not()->toBe(session()->getId());
});

//---------------------------------------------------------------------------------------
//Destroy
it('Deletes the account of the user', function () {
    login($this->user)
        ->delete(route('profile.destroy'))
        ->assertRedirect(route('login.create'));

    expect($this->user->fresh())->toBeNull();
});

//---------------------------------------------------------------------------------------
//Show
it('Includes the user', function () {
    $this->get(route('users.show', [$this->user->id, $this->user->name_normalized]))
        ->assertComponentIs('User/Show')
        ->assertHasKeys([
            'user', 'user.avatar', 'user.name',
            'user.bio', 'user.email', 'user.phone',
            'user.name_normalized'
        ]);
});

it('Includes the favorite posts', function () {
    Post::factory(1)->create();
    Like::factory(1)
        ->for(Post::first(), 'likeable')
        ->recycle($this->user)
        ->create();

    $this->get(route('users.show', [$this->user->id, $this->user->name_normalized]))
        ->assertComponentIs('User/Show')
        ->assertInertia(function (AssertableInertia $page) {
            expect($page->getProp('liked_posts'))
                ->toHaveCount(1)
                ->each()
                ->toHaveKeys(['id', 'title', 'likes_count', 'topic', 'created_at']);
        });
});

it('Includes the posts of the visited user', function () {
    Post::factory(2)->recycle($this->user)->create();

    $this->get(route('users.show', [$this->user->id, $this->user->name_normalized]))
        ->assertComponentIs('User/Show')
        ->assertInertia(function (AssertableInertia $page) {
            expect($page->getProp('authored_posts'))
                ->toHaveCount(2)
                ->each()
                ->toHaveKeys(['id', 'title', 'likes_count', 'topic', 'created_at']);
        });
});



