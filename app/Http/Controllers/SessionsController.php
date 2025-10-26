<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Cjmellor\BrowserSessions\Facades\BrowserSessions;

class SessionsController
{
    public function index()
    {
        //dd(\Cjmellor\BrowserSessions\Facades\BrowserSessions::sessions());
        return Response::json([
            'sessions' => BrowserSessions::sessions()
        ]);
    }

    public function destroy(): RedirectResponse
    {
        BrowserSessions::logoutOtherBrowserSessions();
        return Redirect::back()->banner('Logged out from all devices, except this one.');
    }
}
