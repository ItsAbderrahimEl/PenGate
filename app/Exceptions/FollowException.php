<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class FollowException extends Exception
{
    public function render(): RedirectResponse
    {
        return Redirect::back()->bannerDanger('You cannot follow the same user twice');
    }
}
