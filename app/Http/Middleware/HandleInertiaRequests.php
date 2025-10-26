<?php

namespace App\Http\Middleware;

use Inertia\Inertia;
use Inertia\Middleware;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => Auth::user() ? [
                'user' => UserResource::make(Auth::user()),
                'permissions' => []
            ] : NULL,
            'flash' => Inertia::always([
                'banner' => session('flash.banner') ?? NULL,
                'styleBanner' => session('flash.styleBanner') ?? NULL,
            ]),
            'app' => Inertia::always([
                'name' => env('APP_NAME'),
            ])
        ]);
    }
}
