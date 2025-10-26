<?php

namespace App\Http\Middleware;

use App\Exceptions\RateLimiterException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;


class RateLimiterMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($this->shouldBeChecked($request->method())) {
            $this->checkRateLimiter($request);
        }

        return $next($request);
    }

    private function shouldBeChecked($method): bool
    {
        return in_array($method, ['POST', 'PUT', 'PATCH']);
    }

    private function checkRateLimiter(Request $request): void
    {
        $key = $request->route()?->getName().'|'.$request->ip();

        RateLimiter::hit($key); //Hit before the check more secure

        if (RateLimiter::tooManyAttempts($key, 7))
            throw new RateLimiterException();
    }
}
