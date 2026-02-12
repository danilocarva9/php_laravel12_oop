<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

/**
 * Configure max attempts by an IP at a given time
 */
class RateLimitByIp
{
    const MAX_ATTEMPTS = 10;
    const TIME_TO_WAIT = 60;

    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $key = 'rate_limit:ip:' . $ip;

        if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS)) {
            return response()->json(['message' => "You're doing that too much."], 429);
        }

        RateLimiter::hit($key, self::TIME_TO_WAIT);

        return $next($request);
    }
}
