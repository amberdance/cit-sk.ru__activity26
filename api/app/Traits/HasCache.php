<?php

namespace App\Traits;

use Closure;
use Illuminate\Support\Facades\Cache;

trait HasCache
{

    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return (new static )->getTable();
    }

    /**
     * @param Closure $callback
     * @param int $ttl
     * @param array|null $filter
     *
     * @return mixed
     */
    public static function handleSharedCache(Closure $callback, int $ttl = 3600, ?array $filter = null)
    {

        $dataKey   = self::getTableName();
        $filterKey = $dataKey . '_filter';

        if (Cache::get($filterKey) !== $filter) {
            Cache::forget($filterKey);
            Cache::forget($dataKey);
        }

        Cache::put($filterKey, $filter, $ttl);

        return Cache::remember($dataKey, $ttl, $callback);
    }

    /**
     * @return void
     */
    public static function forgetSharedCache(): void
    {
        $dataKey   = self::getTableName();
        $filterKey = $dataKey . '_filter';

        Cache::forget($dataKey);
        Cache::forget($filterKey);
    }
}
