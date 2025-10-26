<?php

beforeEach(function () {
    $this->user = user();
});

//---------------------------------------------------------------------------------------
//Email Confirmation
it('Returns the email notice', function () {
    login()->get(route('verification.notice'))
        ->assertComponentIs('Auth/VerifyEmail')
        ->assertStatus(200);
});

it('Verify the email', function () {
    $user = unverifiedUser();

    expect($user->hasVerifiedEmail())->toBeFalse();

    $signedUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        [
            'id' => $user->getKey(),
            'hash' => sha1($user->getEmailForVerification()),
        ]
    );

    login($user)->get($signedUrl)->assertRedirect(route('dashboard.show'));

    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
});

