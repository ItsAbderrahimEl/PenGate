<?php

beforeEach(function () {
    $this->user = user();
});

//---------------------------------------------------------------------------------------
//Create
it('Returns the login page', function () {
    $this->get(route('login.create'))
        ->assertComponentIs('Auth/Login')
        ->assertStatus(200);
});

it('Redirect to the posts if logged in', function () {
    login($this->user)->get(route('login.create'))
        ->assertRedirect(route('posts.index'));
});

//---------------------------------------------------------------------------------------
//Post

it('Limits the number of requests for the login form', function () {
    RateLimiter::increment('login.store|127.0.0.1', amount: 8);

    $this->post(route('login.store'))->assertSessionHas([
        'flash.banner' => 'Too many attempts. Please try again later.',
    ]);
});

it('Validates the login form', function () {
    $this->post(route('login.store'), [
        'email' => 'test',
        'password' => 'pass',
    ])->assertSessionHasErrors(['email', 'password']);
});

it("Returns an error if credentials don't match", function () {
    $this->post(route('login.store'), [
        'email' => $this->user->email,
        'password' => 'incorrectPassword',
    ])->assertSessionHasErrors([
        'email' => 'Invalid Credentials.'
    ]);
});

it('login a user', function () {
    $this->post(route('login.store'), [
        'email' => $this->user->email,
        'password' => 'password',
    ])->assertRedirect(route('posts.index'));

    $this->isAuthenticated();
});

//---------------------------------------------------------------------------------------
//Destroy
it("Cannot logout if it's not authenticated", function () {
    $this->delete(route('login.destroy'))->assertRedirect(route('login.create'));
});

it('logout a user', function () {
    login($this->user)->delete(route('login.destroy'))
        ->assertRedirect(route('posts.index'));

    $this->assertGuest();
});