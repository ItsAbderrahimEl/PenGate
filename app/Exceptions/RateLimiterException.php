<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class RateLimiterException extends Exception
{
    public function render(): RedirectResponse
    {
        return Redirect::back()->bannerDanger('Too many attempts. Please try again later.');
    }
}
