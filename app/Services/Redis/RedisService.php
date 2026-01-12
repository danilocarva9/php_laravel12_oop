<?php

namespace App\Services\Redis;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class RedisService
{
    /**
     * Set a value in Redis.
     *
     * @param string $key
     * @param mixed $value
     * @param int|null $expire
     * @return void
     */
    public function set(string $key, $value, ?int $expire = null): void
    {
        Cache::put($key, $value, $expire);
    }

    /**
     * Get a value from Redis.
     *
     * @param string $key
     * @return mixed
     */
    public static function get(string $key)
    {
        return Cache::get($key);
    }

    /**
     * Delete a key from Redis.
     *
     * @param string $key
     * @return void
     */
    public function delete(string $key): void
    {
        Cache::forget($key);
    }
}
