<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationController
{
    public function create(): Response
    {
        return Inertia::render('Auth/VerifyEmail');
    }

    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();

        return redirect()->intended('/dashboard')->banner('Email Verified Successfully');
    }

    public function send(): RedirectResponse
    {
        Auth::user()->sendEmailVerificationNotification();

        return Redirect::back()->banner('Verification link sent!');
    }
}
