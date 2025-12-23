<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class IdempotencyMiddleware
{
    private const TTL = 10; // 10 minutes

    public function handle(Request $request, Closure $next)
    {
        $key = $request->header('Idempotency-Key');

        if (!$key) {
            return response()->json([
                'message' => 'Idempotency-Key header is required'
            ], 400);
        }

        $userId = optional($request->user())->id;
        $cacheKey = "idempotency:{$userId}:{$key}";

        $lock = Cache::lock("lock:{$cacheKey}", 10);

        if (! $lock->get()) {
            return response()->json([
                'message' => 'Request is already being processed'
            ], 409);
        }

        try {
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }

            /** @var Response $response */
            $response = $next($request);

            if ($response->isSuccessful()) {
                Cache::put($cacheKey, $response, self::TTL);
            }

            return $response;
        } finally {
            optional($lock)->release();
        }
    }
}
