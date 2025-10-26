<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SessionController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Login');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email:strict|max:100',
            'password' => 'required|string|min:8|max:100',
        ]);

        if (Auth::attempt($validated, $request->boolean('remember'))) {
            session()->regenerate(true);
            return Redirect::intended('/posts');
        }

        return Redirect::back()->withErrors(['email' => 'Invalid Credentials.']);
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::route('posts.index');
    }
}
