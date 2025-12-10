
<?php

namespace App\Services\Redis;

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
    public function set(string $key, $value, int $expire = null): void
    {
        if ($expire) {
            Redis::setex($key, $expire, $value);
        } else {
            Redis::set($key, $value);
        }
    }

    /**
     * Get a value from Redis.
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return Redis::get($key);
    }

    /**
     * Delete a key from Redis.
     *
     * @param string $key
     * @return void
     */
    public function delete(string $key): void
    {
        Redis::del($key);
    }
}
