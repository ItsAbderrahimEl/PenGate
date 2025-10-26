<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class LikeException extends Exception
{
    public function render(): RedirectResponse
    {
        return Redirect::back()->bannerDanger('You cannot like the same thing twice');
    }
}
