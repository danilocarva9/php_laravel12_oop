<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Modules\Core\Enums\IdempotencyOperationEnum;
use Modules\Core\Models\IdempotencyKey;
use Symfony\Component\HttpFoundation\Response;

class IdempotencyMiddleware
{
    private const TTL = 10; // 10 minutes

    public function handle(Request $request, Closure $next, string $operation)
    {
        $operationEnum = IdempotencyOperationEnum::tryFrom($operation);

        if (! $operationEnum) {
            return response()->json([
                'message' => 'Invalid idempotency operation'
            ], 500);
        }

        $key = $request->header('Idempotency-Key');

        if (!$key) {
            return response()->json([
                'message' => 'Idempotency-Key header is required'
            ], 400);
        }

        $userId = optional($request->user())->id;
        $cacheKey = "idempotency:{$operation}:{$userId}:{$key}";

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

            $record = IdempotencyKey::firstOrCreate(
                ['key' => $key, 'operation' => $operation],
                [
                    'request_hash' => hash('sha256', $request->getContent()),
                    'expires_at' => now()->addMinutes(self::TTL)
                ]
            );

            if (!$record->wasRecentlyCreated) {
                return response()->json([
                    'message' => 'Idempotency key was already processed'
                ], 409);
            }

            /** @var Response $response */
            $response = $next($request);

            if ($response->isSuccessful()) {
                Cache::put($cacheKey, $response, now()->addMinutes(self::TTL));
            }

            return $response;
        } finally {
            optional($lock)->release();
        }
    }
}
