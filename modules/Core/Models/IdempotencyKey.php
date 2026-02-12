<?php

namespace Modules\Core\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Enums\IdempotencyOperationEnum;

class IdempotencyKey extends Model
{
    protected $table = 'idempotency_keys';

    protected $fillable = [
        'key',
        'operation',
        'request_hash',
        'response',
        'expires_at'
    ];

    protected $casts = [
        'operation' => IdempotencyOperationEnum::class,
        'response' => 'array',
        'expires_at' => 'datetime'
    ];

    public function scopeValid(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
                ->orWhere('epires_at', '>', Carbon::now());
        });
    }
}
